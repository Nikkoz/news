<?php
namespace news\forms\auth;

use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => \Yii::t('app', 'Login'),
            'password' => \Yii::t('app', 'Password'),
            'rememberMe' => \Yii::t('app', 'Remember me'),
        ];
    }
}