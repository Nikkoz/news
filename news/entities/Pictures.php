<?php

namespace news\entities;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Pictures
 * @package news\entities\posts
 *
 * @property int $id
 * @property string $name
 * @property string $folder
 * @property string $description
 * @property string $author
 * @property int $sort
 *
 * @mixin ImageUploadBehavior
 */
class Pictures extends ActiveRecord
{
    public static function create(string $file, string $folder = 'common'): self //UploadedFile $file
    {
        $photo = new static();
        $photo->name = $file;
        $photo->folder = $folder;

        return $photo;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public static function tableName(): string
    {
        return '{{%pictures}}';
    }

    /*public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'name',
                'createThumbsOnRequest' => true,
                'filePath' => '@images/origin/[[attribute_folder]]/[[filename]]_[[pk]].[[extension]]',
                'fileUrl' => '/uploads/images/origin/[[attribute_folder]]/[[filename]]_[[pk]].[[extension]]',
                'thumbPath' => '@images/cache/[[attribute_folder]]/[[profile]]_[[filename]]_[[pk]].[[extension]]',
                'thumbUrl' => '/uploads/images/cache/[[attribute_folder]]/[[profile]]_[[filename]]_[[pk]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'cart_list' => ['width' => 150, 'height' => 150],
                    'cart_widget_list' => ['width' => 57, 'height' => 57],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_product_main' => ['width' => 750, 'height' => 1000],
                    'catalog_product_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['width' => 1024, 'height' => 768],
                ],
            ],
        ];
    }*/

    public function getPicture(): ?string
    {
        if ($this->name) {
            $path = "uploads/images/{$this->folder}/" . $this->name;

            $url = str_replace('admin.', '', Url::home(true));

            return $url . $path;
        }

        return null;
    }

    public function getPictureSize(string $size): ?string
    {
        $path = \Yii::getAlias("@imagesStatic/{$this->folder}") . "/thumbnail_{$size}/{$this->name}";
        $file = \Yii::getAlias("@images/{$this->folder}") . "/thumbnail_{$size}/{$this->name}";

        return \file_exists($file) ? $path : '';
    }
}