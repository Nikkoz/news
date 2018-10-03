<?php
namespace news\entities;

use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Pictures
 * @package news\entities\posts
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $author
 * @property int $sort
 */
class Pictures extends ActiveRecord
{
    public static function create(string $file): self
    {
        $photo = new static();
        $photo->name = $file;

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
                'filePath' => '@staticRoot/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
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

    public function getPicture($folder)
    {
        if($this->name) {
            $path = "uploads/images/{$folder}/" . $this->name;

            $url = str_replace('admin.', '', Url::home(true));

            return $url . $path;
        }

        return false;
    }
}