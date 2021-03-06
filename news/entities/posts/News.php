<?php

namespace news\entities\posts;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use news\entities\behaviors\JsonBehavior;
use news\entities\behaviors\MetaBihavior;
use news\entities\Meta;
use news\entities\Pictures;
use news\entities\posts\queries\NewsQuery;
use news\entities\posts\rubric\RubricAssignments;
use news\entities\posts\rubric\Rubrics;
use news\entities\posts\slider\SliderAssignments;
use news\entities\posts\tags\TagAssignments;
use news\entities\posts\video\VideoAssignments;
use news\entities\user\User;
use news\helpers\NewsHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class News
 * @package news\entities\posts
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $sort
 * @property integer $analytic
 * @property integer $news
 * @property string $color
 * @property integer $hot
 * @property integer $discussing
 * @property integer $reading
 * @property integer $choice
 * @property integer $status
 * @property string $preview_text
 * @property array $detail_text
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property integer $rectangle_picture
 * @property integer $square_picture
 * @property integer $hot_picture
 * @property integer $analytic_picture
 *
 * @property Meta $meta
 * @property Rubrics $rubrics
 * @property User $author
 *
 * @property Pictures $rectanglePictureFile
 * @property Pictures $squarePictureFile
 * @property Pictures $analyticPictureFile
 * @property Pictures $hotPictureFile
 *
 * @property RubricAssignments[] $rubricAssignments
 * @property TagAssignments[] $tagAssignments
 * @property SliderAssignments[] $sliderAssignments
 * @property VideoAssignments]\ $videoAssignments
 */
class News extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    public $meta;

    //public $rubrics;

    public static function tableName(): string
    {
        return '{{%news}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => MetaBihavior::class,
                'jsonAttribute' => 'meta_json'
            ], [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'alias',
                'ensureUnique' => true
            ], [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'rubricAssignments', 'tagAssignments', 'sliderAssignments', 'videoAssignments', 'rectanglePictureFile', 'squarePictureFile', 'analyticPictureFile', 'hotPictureFile'
                ]
            ], [
                'class' => JsonBehavior::class,
                'attribute' => 'detail_text'
            ],
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function create(string $title, int $status, int $sort, int $analytics, int $hot, int $news, int $discussing, int $reading, int $choice, string $preview_text, Meta $meta): self
    {
        $post = new static();

        $post->status = $status;
        $post->title = $title;
        $post->sort = $sort;
        $post->analytic = $analytics;
        $post->hot = $hot;
        $post->news = $news;
        $post->discussing = $discussing;
        $post->reading = $reading;
        $post->choice = $choice;
        $post->preview_text = $preview_text;

        $post->meta = $meta;

        return $post;
    }

    public function edit(string $title, int $status, int $sort, int $analytics, int $hot, int $news, int $discussing, int $reading, int $choice, string $preview_text, Meta $meta): void
    {
        $this->status = $status;
        $this->title = $title;
        $this->sort = $sort;
        $this->analytic = $analytics;
        $this->hot = $hot;
        $this->news = $news;
        $this->discussing = $discussing;
        $this->reading = $reading;
        $this->choice = $choice;
        $this->preview_text = $preview_text;

        $this->meta = $meta;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function activate(): void
    {
        if($this->isActive()) {
            throw new \DomainException(\Yii::t('app', 'Article is already active.'));
        }

        $this->status = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isDraft()) {
            throw new \DomainException(\Yii::t('app', 'Article is already inactive.'));
        }

        $this->status = self::STATUS_DRAFT;
    }

    // Photo

    public function assignPicture(int $id, string $column): void
    {
        $this->$column = $id;
    }

    public function revokePicture(string $column): void
    {
        $this->$column = '';
    }

    // Slider

    public function assignSlider($id): void
    {
        $assignments = $this->sliderAssignments;

        foreach ($assignments as $assignment) {
            if ($assignment->isForSlider($id)) {
                return;
            }
        }

        $assignments[] = SliderAssignments::create($id);
        $this->sliderAssignments = $assignments;
    }

    public function revokeSlider($id): void
    {
        $assignments = $this->sliderAssignments;

        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForSlider($id)) {
                unset($assignments[$i]);
                $this->sliderAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeSliders(): void
    {
        $this->sliderAssignments = [];
    }

    // Video

    public function assignVideo($id): void
    {
        $assignments = $this->videoAssignments;

        foreach ($assignments as $assignment) {
            if ($assignment->isForVideo($id)) {
                return;
            }
        }

        $assignments[] = VideoAssignments::create($id);
        $this->videoAssignments = $assignments;
    }

    public function revokeVideo($id): void
    {
        $assignments = $this->videoAssignments;

        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForRubric($id)) {
                unset($assignments[$i]);
                $this->videoAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeVideos(): void
    {
        $this->videoAssignments = [];
    }

    // Rubrics

    public function assignRubric($id): void
    {
        $assignments = $this->rubricAssignments;

        foreach ($assignments as $assignment) {
            if ($assignment->isForRubric($id)) {
                return;
            }
        }

        $assignments[] = RubricAssignments::create($id);
        $this->rubricAssignments = $assignments;
    }

    public function revokeRubric($id): void
    {
        $assignments = $this->rubricAssignments;

        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForRubric($id)) {
                unset($assignments[$i]);
                $this->rubricAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeRubrics(): void
    {
        $this->rubricAssignments = [];
    }

    //tags

    public function assignTag(int $id): void
    {
        $assignments = $this->tagAssignments;

        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }

        $assignments[] = TagAssignments::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag(int $id): void
    {
        $assignments = $this->tagAssignments;

        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    // detail text

    public function setDetailText(array $text): void
    {
        $this->detail_text = $text;
    }

    // assignments

    public function getRubricAssignments(): ActiveQuery
    {
        return $this->hasMany(RubricAssignments::class, ['news_id' => 'id']);
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignments::class, ['news_id' => 'id']);
    }

    public function getSliderAssignments(): ActiveQuery
    {
        return $this->hasMany(SliderAssignments::class, ['news_id' => 'id']);
    }

    public function getVideoAssignments(): ActiveQuery
    {
        return $this->hasMany(VideoAssignments::class, ['news_id' => 'id']);
    }

    public function getRectanglePictureFile(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id' => 'rectangle_picture']);
    }

    public function getSquarePictureFile(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id' => 'square_picture']);
    }

    public function getAnalyticPictureFile(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id' => 'analytic_picture']);
    }

    public function getHotPictureFile(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id' => 'hot_picture']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getRectanglePicture(): string
    {
        return $this->rectanglePictureFile ? $this->rectanglePictureFile->getPicture() : '';
    }

    public function getAnalyticPicture(): string
    {
        return $this->analyticPictureFile ? $this->analyticPictureFile->getPicture() : '';
    }

    public function getSquarePicture(string $size = null)
    {
        if (!$this->square_picture) {
            return '';
        }

        return $size ? $this->squarePictureFile->getPictureSize($size) : $this->squarePictureFile->getPicture();
    }

    public function getTags(): array
    {
        $tags = [];
        foreach ($this->tagAssignments as $assignment) {
            $tags[] = $assignment->getTag()->name;
        }

        return $tags;
    }

    public function checkRubric(string $rubric): bool
    {
        foreach ($this->rubricAssignments as $rubricAssignment) {
            if ($rubric === $rubricAssignment->rubric->slug) {
                return true;
            }
        }

        return false;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
    }

    public function attributeLabels(): array
    {
        return NewsHelper::attributeLabels();
    }

    public static function find(): NewsQuery
    {
        return new NewsQuery(static::class);
    }
}