<?php

namespace frontend\urls;


use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class AnalyticUrlRule extends BaseObject implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'analytics/index') {
            if (isset($params['alias'])) {
                return 'analytics/' . $params['alias'];
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