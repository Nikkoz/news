<?php

namespace frontend\urls;


use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use yii\base\BaseObject;
use yii\caching\TagDependency;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

/**
 * Class AnalyticUrlRule
 * @package frontend\urls
 *
 * @property NewsReadRepository $newsRepository
 * @property RubricsReadRepository $rubricsRepository
 */
class AnalyticUrlRule extends BaseObject implements UrlRuleInterface
{
    public $prefix = 'analytic';

    private $newsRepository;
    private $rubricsRepository;

    public function __construct(
        NewsReadRepository $newsRepository,
        RubricsReadRepository $rubricsRepository,
        array $config = []
    )
    {
        parent::__construct($config);

        $this->rubricsRepository = $rubricsRepository;
        $this->newsRepository = $newsRepository;
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'posts/post/analytic') {
            if (isset($params['alias'])) {
                return "{$this->prefix}/{$params['alias']}";
            }
        }

        return false;
    }

    public function parseRequest($manager, $request)
    {
        \Yii::$app->cache->flush();

        if (\preg_match('%^' . $this->prefix . '(\/[a-z0-9-]+)$%is', $request->pathInfo, $matches)) {
            $post = \trim($matches['1'], '/');

            $result = \Yii::$app->cache->getOrSet(['analytics_route', 'post' => $post], function () use ($post) {
                if (!$article = $this->newsRepository->getByAlias($post)) {
                    return ['alias' => null];
                }

                return ['alias' => $article->alias, 'rubric' => !$article->analytic ? $article->rubricAssignments[0]->rubric->slug : ''];
            }, null, new TagDependency(['tags' => ['posts']]));

            if (empty($result['alias'])) {
                return false;
            }

            if ($result['rubric']) {
                throw new UrlNormalizerRedirectException(['posts/rubrics/post', 'rubric' => $result['rubric'], 'post' => $result['alias']], 301);
            }

            return ['posts/post/analytic', ['alias' => $post]];
        }

        return false;
    }
}