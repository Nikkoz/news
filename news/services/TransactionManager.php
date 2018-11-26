<?php
namespace news\services;


use news\dispatchers\DeferredEventDispatcher;

class TransactionManager
{
    private $dispatcher;

    public function __construct(DeferredEventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param callable $function
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function wrap(callable $function): void
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->dispatcher->defer();
            $function();
            $transaction->commit();
            $this->dispatcher->release();
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->dispatcher->clean();

            throw $e;
        }
    }
}