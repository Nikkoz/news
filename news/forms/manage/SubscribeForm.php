<?php

namespace news\forms\manage;


use news\entities\Subscribe;
use yii\base\Model;

/**
 * Class SubscribeForm
 * @package news\forms\manage
 *
 * @property string $email
 */
class SubscribeForm extends Model
{
    public $email;

    public function __construct(Subscribe $subscribe = null, array $config = [])
    {
        if ($subscribe) {
            $this->email = $subscribe->email;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email']
        ];
    }
}