<?php

namespace news\services;


use yii\rbac\ManagerInterface;

/**
 * Class RoleManager
 * @package news\services
 *
 * @property ManagerInterface $manager
 */
class RoleManager
{
    private $manager;

    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param int $userId
     * @param string $name
     * @throws \Exception
     */
    public function assign(int $userId, string $name): void
    {
        $am = $this->manager;
        $am->revokeAll($userId);

        if (!$role = $am->getRole($name)) {
            throw new \DomainException("Role \"{$name}\" does not exist.");
        }
        $am->revokeAll($userId);
        $am->assign($role, $userId);
    }
}