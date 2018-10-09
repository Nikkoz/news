<?php

namespace news\entities\posts;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use news\entities\behaviors\JsonBehavior;
use news\entities\behaviors\MetaBihavior;
use news\entities\Meta;
use news\entities\Pictures;
use news\entities\posts\rubric\RubricAssignments;
use news\entities\posts\rubric\Rubrics;
use news\entities\posts\slider\SliderAssignments;
use news\entities\posts\video\VideoAssignments;
use news\helpers\NewsHelper;
use phpDocumentor\Reflection\Types\Self_;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class News
 * @package news\entities\posts
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $sort
 * @property integer $analytic
 * @property integer $hot
 * @property integer $discussing
 * @property integer $reading
 * @property integer $choice
 * @property integer $status
 * @property string $preview_text
 * @property array $detail_text
 *
 * @property integer $rectangle_picture
 * @property integer $square_picture
 * @property integer $hot_picture
 * @property integer $analytic_picture
 *
 * @property Meta $meta
 * @property Rubrics $rubrics
 *
 * @property Pictures $rectanglePictureFile
 * @property Pictures $squarePictureFile
 * @property Pictures $analyticPictureFile
 * @property Pictures $hotPictureFile
 *
 * @property RubricAssignments $rubricAssignments
 * @property SliderAssignments $sliderAssignments
 * @property VideoAssignments $videoAssignments
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
                    'rubricAssignments', 'sliderAssignments', 'videoAssignments', 'rectanglePictureFile', 'squarePictureFile', 'analyticPictureFile', 'hotPictureFile'
                ]
            ], [
                'class' => JsonBehavior::class,
                'attribute' => 'detail_text'
            ]
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function create(string $title, int $status, int $sort, int $analytics, int $hot, int $discussing, int $reading, int $choice, string $preview_text, Meta $meta): self
    {
        $news = new static();

        $news->status = $status;
        $news->title = $title;
        $news->sort = $sort;
        $news->analytic = $analytics;
        $news->hot = $hot;
        $news->discussing = $discussing;
        $news->reading = $reading;
        $news->choice = $choice;
        $news->preview_text = $preview_text;

        $news->meta = $meta;

        return $news;
    }

    public function edit(string $title, int $status, int $sort, int $analytics, int $hot, int $discussing, int $reading, int $choice, string $preview_text, Meta $meta): void
    {
        $this->status = $status;
        $this->title = $title;
        $this->sort = $sort;
        $this->analytic = $analytics;
        $this->hot = $hot;
        $this->discussing = $discussing;
        $this->reading = $reading;
        $this->choice = $choice;
        $this->preview_text = $preview_text;

        $this->meta = $meta;
    }

    public function isActivate(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function activate(): void
    {
        if($this->isActivate()) {
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

    public function attributeLabels(): array
    {
        return NewsHelper::attributeLabels();
    }

}