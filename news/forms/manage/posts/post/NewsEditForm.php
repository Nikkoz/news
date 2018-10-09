<?php

namespace news\forms\manage\posts\post;


use news\entities\posts\News;
use news\entities\posts\slider\Sliders;
use news\entities\posts\video\Videos;
use news\forms\manage\CompositeForm;
use news\forms\manage\MetaForm;
use news\helpers\NewsHelper;

/**
 * Class NewsCreateForm
 * @package news\forms\manage\posts
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $sort
 * @property boolean $analytics
 * @property boolean $hot
 * @property boolean $discussing
 * @property boolean $reading
 * @property boolean $choice
 * @property integer $status
 * @property string $preview_text
 * @property array $detail_text
 *
 * @property News $_post
 *
 * @property array $_sliders
 * @property array $_videos
 *
 * @property MetaForm $meta
 * @property RubricsForm $rubrics
 * @property PicturesForm $pictures
 * @property SlidersForm $sliders
 * @property VideosForm $videos
 */
class NewsEditForm extends CompositeForm
{
    public $id;
    public $title;
    public $alias;
    public $sort;
    public $analytics;
    public $hot;
    public $discussing;
    public $reading;
    public $choice;
    public $status;
    public $preview_text;
    public $detail_text;

    public $_post;

    private $_sliders = [];
    private $_videos = [];

    public function __construct(News $news, array $config = [])
    {
        $this->id = $news->id;
        $this->title = $news->title;
        $this->alias = $news->alias;
        $this->sort = $news->sort;
        $this->analytics = $news->analytic;
        $this->hot = $news->hot;
        $this->discussing = $news->discussing;
        $this->reading = $news->reading;
        $this->choice = $news->choice;
        $this->status = $news->status;
        $this->preview_text = $news->preview_text;
        $this->detail_text = $news->detail_text;

        $this->meta = new MetaForm($news->meta);
        $this->rubrics = new RubricsForm($news);
        $this->pictures = new PicturesForm($news);

        $sliders = [];
        $videos = [];

        foreach ($news->sliderAssignments as $i => $assignment) {
            $slider = $assignment->getSlider();

            $sliders[] = new SlidersForm($slider, $i);
            $this->_sliders[$slider->id] = $slider;
        }

        foreach ($news->videoAssignments as $i => $assignment) {
            $video = $assignment->getVideo();

            $videos[] = new VideosForm($video, $i);
            $this->_videos[$video->id] = $video;
        }

        $this->sliders = $sliders ? $sliders : [new SlidersForm()];
        $this->videos = $videos ? $videos : [new VideosForm()];

        $this->_post = $news;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'detail_text'], 'required'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['preview_text'], 'string'],
            //[['alias'], 'unique', 'targetClass' => News::class, 'filter' => $this->_post ? ['<>', 'id', $this->_post->id] : null],
            ['sort', 'integer'],
            ['detail_text', 'safe'],
            [['sort'], 'default', 'value' => 100],
            [['analytics', 'hot', 'discussing', 'reading', 'choice', 'status'], 'integer', 'max' => 1],
        ];
    }

    protected function internalForms(): array
    {
        return ['pictures', 'sliders', 'videos', 'meta', 'rubrics'];
    }

    public function setSliders(array $sliders): array
    {
        $result = [];

        foreach ($sliders as $i => $slider) {
            if (isset($this->sliders[$i])) {
                $result[$i] = $this->sliders[$i];
            } else {
                $result[$i] = new SlidersForm(null, $i);
            }
        }

        return $result;
    }

    public function setVideos(array $videos): array
    {
        $result = [];

        foreach ($videos as $i => $video) {
            if (isset($this->videos[$i])) {
                $result[$i] = $this->videos[$i];
            } else {
                $result[$i] = new VideosForm(null, $i);
            }
        }

        return $result;
    }

    public function getSliderById(int $id): ?Sliders
    {
        return $this->_sliders[$id] ?? null;
    }

    public function getVideoById(int $id): ?Videos
    {
        return $this->_videos[$id] ?? null;
    }

    public function getTizerById(int $id): ?News
    {
        return News::findOne($id) ?? null;
    }

    public function attributeLabels(): array
    {
        return NewsHelper::attributeLabels();
    }
}