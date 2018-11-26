<?php
namespace news\repositories;


use news\entities\Pictures;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class PicturesRepository
{
    public function get(int $id): Pictures
    {
        if(!$picture = Pictures::findOne($id)) {
            throw new \DomainException('Pictures is not found.' . $id);
        }

        return $picture;
    }

    public function save(Pictures $picture): void
    {
        if(!$picture->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Pictures $picture): void
    {
        if(!$picture->delete()) {
            throw new \RuntimeException('Removing error.');
        } else {
            $this->removeFile($picture->name, $picture->folder);
        }
    }

    /**
     * @param UploadedFile $file
     * @param string $folder
     * @param string|array $size
     * @return string
     * @throws \yii\base\Exception
     */
    public function saveFile(UploadedFile $file, string $folder = 'posts', $size = null): string
    {
        $dir = \Yii::getAlias('@images') . "/{$folder}/";
        $this->createDirectory($dir);

        if(file_exists($dir . $file->name)) {
            unlink($dir . $file->name);
        }

        $image = time() . '_' . \Yii::$app->security->generateRandomString(6) . '.' . $file->extension;
        $file->saveAs($dir . $image);

        if($size) {
            if(!is_array($size)) {
                $size = [$size];
            }

            foreach ($size as $s) {
                $this->resize($dir, $s, $image);
            }
        }

        return $image;
    }

    public function removeFile(string $fileName, string $folder = 'posts'): void
    {
        $dir = \Yii::getAlias('@images') . "/{$folder}/";

        if(file_exists($dir . $fileName)) {
            unlink($dir . $fileName);
        }

        if($folder == 'users') {
            if(file_exists($dir . 'thumbnail_64x64/' . $fileName)) {
                unlink($dir . 'thumbnail_64x64/' . $fileName);
            }

            if(file_exists($dir . 'thumbnail_40x40/' . $fileName)) {
                unlink($dir . 'thumbnail_40x40/' . $fileName);
            }
        }
    }

    private function createDirectory(string $dir): void
    {
        if(!file_exists($dir)) {
            try {
                FileHelper::createDirectory($dir);
            } catch (\yii\base\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }
    }

    private function resize(string $dir, string $size, string $image): void
    {
        list($width, $height) = explode('x', $size);

        $this->createDirectory("{$dir}thumbnail_{$size}/");
        Image::thumbnail($dir . $image, $width, $height)->save("{$dir}thumbnail_{$size}/{$image}", ['quality' => 70]);
    }
}