<?php
namespace news\services\manage\posts;


use news\entities\Meta;
use news\entities\Pictures;
use news\entities\posts\News;
use news\forms\manage\posts\post\NewsCreateForm;
use news\forms\manage\posts\post\NewsEditForm;
use news\forms\manage\posts\post\SlidersForm;
use news\forms\manage\posts\post\VideosForm;
use news\repositories\PicturesRepository;
use news\repositories\posts\NewsRepository;
use news\repositories\posts\rubrics\RubricsRepository;
use news\repositories\posts\SlidersRepository;
use news\repositories\posts\TagsRepository;
use news\repositories\posts\VideosRepository;
use news\services\TransactionManager;
use yii\helpers\ArrayHelper;

/**
 * Class NewsManageService
 * @package news\services\manage\posts
 *
 * @property NewsRepository $repository
 * @property RubricsRepository $rubricRepository
 * @property TagsRepository $tagRepository
 * @property TransactionManager $transaction
 * @property PicturesRepository $pictureRepository
 * @property SlidersRepository $sliderRepository
 * @property VideosRepository $videoRepository
 *
 * @property SlidersManageService $sliderService
 * @property VideosManageService $videoService
 */
class NewsManageService
{
    private $repository;
    private $rubricRepository;
    private $pictureRepository;
    private $sliderRepository;

    private $sliderService;

    private $rubrics;
    private $transaction;

    public function __construct(
        NewsRepository $repository,
        RubricsRepository $rubricsRepository,
        TagsRepository $tagRepository,
        PicturesRepository $pictureRepository,
        SlidersRepository $sliderRepository,
        VideosRepository $videoRepository,
        TransactionManager $transaction,
        SlidersManageService $sliderService,
        VideosManageService $videoService
    )
    {
        $this->repository = $repository;
        $this->rubricRepository = $rubricsRepository;
        $this->tagRepository = $tagRepository;
        $this->pictureRepository = $pictureRepository;
        $this->sliderRepository = $sliderRepository;
        $this->videoRepository = $videoRepository;
        $this->transaction = $transaction;
        $this->sliderService = $sliderService;
        $this->videoService = $videoService;
    }

    public function create(NewsCreateForm $form): News
    {
        $news = News::create(
            $form->title,
            $form->status,
            $form->sort,
            $form->analytics,
            $form->hot,
            $form->news,
            $form->discussing,
            $form->reading,
            $form->choice,
            $form->preview_text,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if ($form->color) {
            $news->setColor($form->color);
        }

        foreach ($form->rubrics->rubrics as $rubric) {
            $rubric = $this->rubricRepository->get($rubric);
            $news->assignRubric($rubric->id);
        }

        foreach ($form->tags->tags as $tag) {
            $tag = $this->tagRepository->get($tag);
            $news->assignTag($tag->id);
        }

        $this->transaction->wrap(function () use ($news, $form) {
            if($form->pictures->squarePictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->squarePictureFile, 'posts', ['64x64', '120x120']);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $news->assignPicture($picture->id, 'square_picture');
            }

            if($form->pictures->hotPictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->hotPictureFile);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $news->assignPicture($picture->id, 'hot_picture');
            }

            if($form->pictures->rectanglePictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->rectanglePictureFile);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $news->assignPicture($picture->id, 'rectangle_picture');
            }

            if($form->pictures->analyticPictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->analyticPictureFile);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $news->assignPicture($picture->id, 'analytic_picture');
            }

            $sliders = [];

            foreach ($form->sliders as $slide) {
                if($slide->pictures) {
                    $slider = $this->sliderService->create($slide);
                    $sliders[$slider->id] = $slider->name;

                    $news->assignSlider($slider->id);
                }
            }

            $videos = [];

            foreach ($form->videos as $video) {
                if($video->link && !empty($video->picture)) {
                    $video = $this->videoService->create($video);
                    $videos[$video->id] = $video->name;

                    $news->assignVideo($video->id);
                }
            }

            foreach ($form->detail_text as $i => $item) {
                if(!empty($item['slider'])) {
                    $key = \array_search($item['slider'], $sliders);
                    $form->detail_text[$i]['slider'] = $key;

                    unset($sliders[$key]);
                }

                if(!empty($item['video'])) {
                    $key = \array_search($item['video'], $videos);
                    $form->detail_text[$i]['video'] = $key;

                    unset($videos[$key]);
                }
            }

            $news->setDetailText($form->detail_text);

            $this->repository->save($news);
        });

        return $news;
    }

    public function edit(int $id, NewsEditForm $form): void
    {
        $news = $this->repository->get($id);

        $news->edit(
            $form->title,
            $form->status,
            $form->sort,
            $form->analytics,
            $form->hot,
            $form->news,
            $form->discussing,
            $form->reading,
            $form->choice,
            $form->preview_text,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if ($form->color) {
            $news->setColor($form->color);
        }

        $this->transaction->wrap(function() use ($form, $news) {
            //$news->revokeSliders();
            //$news->revokeVideos();
            $news->revokeRubrics();
            $news->revokeTags();

            $this->repository->save($news);

            foreach ($form->rubrics->rubrics as $rubric) {
                $rubric = $this->rubricRepository->get($rubric);
                $news->assignRubric($rubric->id);
            }

            foreach ($form->tags->tags as $tag) {
                $tag = $this->tagRepository->get($tag);
                $news->assignTag($tag->id);
            }

            if($form->pictures->rectanglePictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->rectanglePictureFile);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $this->checkPicture($picture->id, $news->rectangle_picture);

                $news->assignPicture($picture->id, 'rectangle_picture');
            }

            if($form->pictures->squarePictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->squarePictureFile, 'posts', ['64x64', '120x120']);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $this->checkPicture($picture->id, $news->square_picture);

                $news->assignPicture($picture->id, 'square_picture');
            }

            if($form->pictures->hotPictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->hotPictureFile);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $this->checkPicture($picture->id, $news->hot_picture);

                $news->assignPicture($picture->id, 'hot_picture');
            }

            if($form->pictures->analyticPictureFile) {
                $file = $this->pictureRepository->saveFile($form->pictures->analyticPictureFile);

                $picture = Pictures::create($file, 'posts');
                $this->pictureRepository->save($picture);

                $this->checkPicture($picture->id, $news->analytic_picture);

                $news->assignPicture($picture->id, 'analytic_picture');
            }

            $assign = ArrayHelper::getColumn((array)$news->sliderAssignments, 'slider_id');
            $sliders = [];

            foreach ($form->sliders as $slide) {
                if(!empty($slide->pictures)) {
                    if(in_array($slide->id, $assign)) {
                        $this->sliderService->edit($slide->id, $slide);

                        $sliders[$slide->id] = $slide->name;
                    } else {
                        $slider = $this->sliderService->create($slide);

                        $sliders[$slider->id] = $slider->name;

                        $news->assignSlider($slider->id);
                    }
                } else {
                    $sliders[$slide->id] = $slide->name;
                }
            }

            $assign = ArrayHelper::getColumn((array)$news->videoAssignments, 'video_id');
            $videos = [];

            foreach ($form->videos as $v) {
                if($v->link && !empty($v->picture)) {
                    if(in_array($v->id, $assign)) {
                        $this->videoService->edit($v->id, $v);

                        $videos[$v->id] = $v->name;
                    } else {
                        $video = $this->videoService->create($v);

                        $videos[$video->id] = $video->name;

                        $news->assignVideo($video->id);
                    }
                } else {
                    $videos[$v->id] = $v->name;
                }
            }

            foreach ($form->detail_text as $i => $item) {
                if(!empty($item['slider'])) {
                    $key = \array_search($item['slider'], $sliders);
                    $form->detail_text[$i]['slider'] = $key;

                    unset($sliders[$key]);
                }

                if(!empty($item['video'])) {
                    $key = \array_search($item['video'], $videos);
                    $form->detail_text[$i]['video'] = $key;

                    unset($videos[$key]);
                }
            }

            $news->setDetailText($form->detail_text);

            $this->repository->save($news);
        });
    }

    public function remove($id): void
    {
        $news = $this->repository->get($id);

        $this->removePicturesNews($news);
        $this->removeSlidersNews($news);
        $this->removeVideosNews($news);

        $this->repository->remove($news);
    }

    public function removePicture(int $id, string $column): void
    {
        $news = $this->repository->get($id);
        $picture = $this->pictureRepository->get($news->$column);

        $news->revokePicture($column);
        $this->pictureRepository->remove($picture);
    }

    public function removeSliderPicture(int $id, int $pictureId): void
    {
        $slider = $this->sliderRepository->get($id);
        $picture = $this->pictureRepository->get($pictureId);

        $slider->revokePicture($pictureId);
        $this->pictureRepository->remove($picture);
    }

    public function removeVideoPicture(int $id, int $pictureId): void
    {
        $video = $this->videoRepository->get($id);
        $picture = $this->pictureRepository->get($pictureId);

        $video->revokePicture();
        $this->pictureRepository->remove($picture);
    }

    private function removePicturesNews(News $news): void
    {
        $fields = ['hot_picture', 'rectangle_picture', 'square_picture', 'analytic_picture'];

        foreach ($fields as $column) {
            if($news->$column) {
                $picture = $this->pictureRepository->get($news->$column);
                $this->pictureRepository->remove($picture);
            }
        }
    }

    private function removeSlidersNews(News $news): void
    {
        if($news->sliderAssignments) {
            foreach ($news->sliderAssignments as $sliderAssignment) {
                $this->removeSlider($sliderAssignment->slider_id);
            }
        }
    }

    private function removeVideosNews(News $news): void
    {
        if($news->videoAssignments) {
            foreach ($news->videoAssignments as $videoAssignment) {
                $this->removeVideo($videoAssignment->video_id);
            }
        }
    }

    private function checkPicture(int $newId, int $id = null): void
    {
        if($id && $id != $newId) {
            $picture = $this->pictureRepository->get($id);
            $this->pictureRepository->remove($picture);
        }
    }

    public function updateSlider(int $id, SlidersForm $form): void
    {
        $this->sliderService->edit($id, $form);
    }

    public function removeSlider(int $id): void
    {
        $this->sliderService->remove($id);
    }

    public function updateVideo(int $id, VideosForm $form): void
    {
        $this->videoService->edit($id, $form);
    }

    public function removeVideo(int $id): void
    {
        $this->videoService->remove($id);
    }

    public function activate(int $id): void
    {
        $article = $this->repository->get($id);
        $article->activate();
        $this->repository->save($article);
    }

    public function deactivate(int $id): void
    {
        $article = $this->repository->get($id);
        $article->deactivate();
        $this->repository->save($article);
    }

    public function getAllArticlesWithoutCurrent(int $current = null): array
    {
        return $this->repository->getBy($current ? ['<>', 'id', $current] : []);
    }

    public function setDetailText(array $_post): array
    {
        $data = [];

        if(!empty($_post['order'])) {
            foreach ($_post['order'] as $position) {
                list($type, $pos) = explode('_',$position);

                switch($type) {
                    case 'tizer':
                        $data[$pos][$type] = $_post[$position];
                        $data[$pos]['text'] = $_post["text_{$pos}"];
                        break;
                    case 'text':
                    case 'slider':
                    case 'video':
                        $data[$pos][$type] = $_post[$position];
                        break;
                }
            }
        }

        return $data;
    }
}