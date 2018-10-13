<?php

namespace news\forms\manage\users;


use news\entities\User;
use news\forms\manage\CompositeForm;
use news\helpers\UsersHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class UserForm
 * @package news\forms\manage\
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $name
 * @property string $lastname
 * @property string $role
 * @property int $status
 *
 * @property string $password
 * @property string $password_confirm
 *
 * @property PhotoForm $photo
 * @property User $_user
 *
 * @property array $statusList
 * @property array $rolesList
 * @property string fullName
 */
class UserForm extends CompositeForm
{
    public $id;
    public $username;
    public $email;
    public $name;
    public $lastname;
    public $password;
    public $password_confirm;
    public $role;
    public $status;

    private $_user;

    public function __construct(User $user = null, array $config = [])
    {
        if($user) {
            $roles = \Yii::$app->authManager->getRolesByUser($user->id);

            $this->id = $user->id;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->name = $user->name;
            $this->lastname = $user->lastname;
            $this->status = $user->status;
            $this->role = $roles ? reset($roles)->name : null;

            $this->_user = $user;
        }

        $this->photo = new PhotoForm($user);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [ArrayHelper::merge(
                ['username', 'name', 'lastname', 'role'],
                $this->_user ? [] : ['password']
            ), 'required'],
            ['email', 'email'],
            [['username', 'name', 'lastname', 'email'], 'string', 'max' => 255],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'filter' => $this->_user ? ['<>', 'id', $this->_user->id] : null,
                'message' => \Yii::t('app', 'This login has already been taken.')
            ], [
                'email',
                'unique',
                'targetClass' => User::class,
                'filter' => $this->_user ? ['<>', 'id', $this->_user->id] : null,
                'message' => \Yii::t('app', 'This E-mail has already been taken.')
            ],
            ['status', 'integer'],
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['password', 'string', 'min' => 6, 'max' => 15],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function getStatusList(): array
    {
        return [
            User::STATUS_ACTIVE => \Yii::t('app', 'Active'),
            User::STATUS_INACTIVE => \Yii::t('app', 'Inactive'),
        ];
    }

    public function getRolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public function getFullName(): string
    {
        return $this->lastname . ' ' . $this->name;
    }

    protected function internalForms(): array
    {
        return ['photo'];
    }

    public function attributeLabels(): array
    {
        return UsersHelper::attributeLabels();
    }
}