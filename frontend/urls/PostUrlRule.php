<?php

namespace frontend\urls;


use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use yii\base\BaseObject;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

/**
 * Class PostUrlRule
 * @package frontend\urls
 *
 * @property NewsReadRepository $newsRepository
 * @property RubricsReadRepository $rubricsRepository
 */
class PostUrlRule extends BaseObject implements UrlRuleInterface
{
    public $prefix = 'rubrics';

    private $newsRepository;
    private $rubricsRepository;

    public function __construct(
        NewsReadRepository $newsRepository,
        RubricsReadRepository $rubricsRepository,
        array $config = []
    )
    {
        parent::__construct($config);

        $this->rubricsRepository = $rubricsRepository;
        $this->newsRepository = $newsRepository;
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'posts/post/index') {
            if (isset($params['rubric'], $params['post'])) {
                $rubricAlias = $params['rubric'];
                $postAlias = $params['post'];

                return "{$this->prefix}/{$rubricAlias}/{$postAlias}";
            } elseif (isset($params['rubric'])) {
                return "{$this->prefix}/{$params['rubric']}";
            }
        }

        return false;
    }

    public function parseRequest($manager, $request)
    {
        if (\preg_match('%^' . $this->prefix . '(\/[a-z-]+)(\/[a-z0-9-]+)$%is', $request->pathInfo, $matches)) {
            $rubric = \trim($matches['1'], '/');
            $post = \trim($matches['2'], '/');

            $result = \Yii::$app->cache->getOrSet(['post_route', 'post' => $post], function () use ($post, $rubric) {
                if (!$article = $this->newsRepository->getByAlias($post)) {
                    return ['rubric' => null, 'post' => null];
                }

                $rubric = $article->checkRubric($rubric) ? $rubric : $article->rubricAssignments[0]->rubric->slug;

                return ['rubric' => $rubric, 'post' => $article->alias];
            }, null, new TagDependency(['tags' => ['posts']]));

            if (empty($result['post'])) {
                return false;
            }

            if ($rubric != $result['rubric']) {
                throw new UrlNormalizerRedirectException(['posts/rubrics/post', 'rubric' => $result['rubric'], 'post' => $result['post']], 301);
            }

            return ['posts/post/index', ['rubric' => $rubric, 'post' => $post]];
        }

        return false;
    }
}