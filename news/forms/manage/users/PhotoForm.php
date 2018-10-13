<?php

namespace news\forms\manage\users;


use news\entities\User;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class PhotoForm
 * @package news\forms\manage\users
 *
 * @property $photo
 */
class PhotoForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $photo;
    public $id;

    public function __construct(User $user = null, array $config = [])
    {
        if($user) {
            $this->photo = $user->photoFile;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['photo'], 'image'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');

            return true;
        }
        return false;
    }

    public function getId(): ?int
    {
        return $this->photo ? $this->photo->id : null;
    }

    public function attributeLabels(): array
    {
        return [
            'photo' => \Yii::t('app', 'Photo'),
        ];
    }
}