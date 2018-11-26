<?php

namespace frontend\urls;


use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class PostUrlRule extends BaseObject implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'rubrics/post') {
            if (isset($params['rubric'], $params['post'])) {
                return 'rubrics/' . $params['rubric'] . '/' . $params['post'];
            } elseif (isset($params['rubric'])) {
                return 'rubrics/' . $params['rubric'];
            }
        }

        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {

        }
        return false;
    }
}