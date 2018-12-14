<?php

namespace news\entities\user;

use news\entities\AggregateRoot;
use news\entities\EventTrait;
use news\entities\Pictures;
use news\entities\user\events\UserCreateRequested;
use news\helpers\NewsHelper;
use news\helpers\UsersHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

//use yii\base\StaticInstanceTrait;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $lastname
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password
 * @property int $last_auth
 * @property int $photo
 * @property Pictures $photoFile
 */
class User extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    const STATUS_INACTIVE = 0;
    //const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
        ];
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $name
     * @param string $lastname
     * @param string $password
     * @return User
     * @throws \yii\base\Exception
     */
    public static function create(string $username, string $email, string $name, string $lastname, string $password): self
    {
        $user = new static();
        $user->username = $username;
        $user->email = $email;
        $user->name = $name;
        $user->lastname = $lastname;
        $user->setPassword(!empty($password) ? $password : Yii::$app->security->generateRandomString());
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->auth_key = Yii::$app->security->generateRandomString();

        $user->recordEvent(new UserCreateRequested($user));

        return $user;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $name
     * @param string $lastname
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function edit(string $username, string $email, string $name, string $lastname, string $password = ''): void
    {
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->updated_at = time();

        if(!empty($password)) {
            $this->setPassword($password);
        }
    }

    /*public static function signup(string $username, string $email, string $password): self
    {
        $user = new static();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();

        return $user;
    }*/

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    public function activate(): void
    {
        if($this->isActive()) {
            throw new \DomainException(\Yii::t('app', 'User is already active.'));
        }

        $this->status = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'User is already inactive.'));
        }

        $this->status = self::STATUS_INACTIVE;
    }

    /*public function isWait()
    {
        return $this->status === self::STATUS_WAIT;
    }*/

    /*public function confirmSignup():void
    {
        if(!$this->isWait()) {
            throw new \DomainException('User is already active.');
        }

        $this->status = self::STATUS_ACTIVE;
        $this->email_confirm_token = null;
    }*/

    // Photo

    public function assignPhoto(int $id): void
    {
        $this->photo = $id;
    }

    public function revokePhoto(): void
    {
        $this->photo = '';
    }

    public function getPhotoFile(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id' => 'photo']);
    }

    public function getFullName(bool $revers = false): string
    {
        $name = [$this->name, $this->lastname];
        if ($revers) {
            $name = \array_reverse($name);
        }
        return \implode(' ', $name);
    }

    public function getPhotoMin(string $size): string
    {
        $picture = Pictures::findOne($this->photo);
        $file = $picture ? \Yii::getAlias('@imagesStatic/users') . "/thumbnail_{$size}/{$picture->name}" : '';

        return $file;
    }

    public function getCountPosts(): int
    {
        return NewsHelper::countByAuthor($this->id);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Password resetting is already requested.');
        }

        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Password resetting is not requested.');
        }

        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken(string $token): ?self
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     *
     * @throws \yii\base\Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function attributeLabels(): array
    {
        return UsersHelper::attributeLabels();
    }
}
