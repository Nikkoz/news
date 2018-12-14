<?php

namespace news\readModels;


use news\entities\user\User;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\rbac\ManagerInterface;

/**
 * Class AuthorsReadRepository
 * @package news\readModels
 *
 * @property ManagerInterface $manager
 * @property Cache $cache
 */
class AuthorsReadRepository
{
    private $manager;
    private $cache;

    public function __construct(ManagerInterface $manager, Cache $cache)
    {
        $this->manager = $manager;
        $this->cache = $cache;
    }

    public function count()
    {
        return \count($this->getAuthorIDs());
    }

    public function getAuthorIDs()
    {
        return $this->cache->getOrSet(['authors'], function () {
            return $this->manager->getUserIdsByRole('author');
        }, 3600, new TagDependency(['tags' => ['authors_count']]));
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAuthors(): array
    {
        return User::find()->andWhere(['=', 'status', User::STATUS_ACTIVE])->all();
    }

    public function getAuthor(int $id): ?User
    {
        return User::find()->andWhere(['id' => $id])->limit(1)->one();
    }
}