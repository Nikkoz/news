<?php

namespace news\forms;


use news\entities\Subscribe;
use yii\base\Model;

/**
 * Class SubscribeForm
 * @package news\forms
 *
 * @property string $email
 * @property boolean $agree
 */
class SubscribeForm extends Model
{
    public $email;
    public $agree;

    public function rules(): array
    {
        return [
            [['email', 'agree'], 'required'],
            ['email', 'email'],
            ['agree', 'compare', 'compareValue' => 1],
            ['email', 'unique', 'targetClass' => Subscribe::class]
        ];
    }
}