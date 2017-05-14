<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;

/**
 * A class of lk url rule
 *
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class UrlRule extends Object implements UrlRuleInterface
{
    /**
     * Creates url for form
     * @see \app\components\PageUrlRule::createUrl
     * @param object $manager
     * @param string $route
     * @param array $params
     * @return boolean|array|string
     */
    public function createUrl($manager, $route, $params)
    {
        $url = '';        
        return false;  // this rule does not apply
    }
    
    /**
     * Parses URL for article or article section
     * @see \app\components\PageUrlRule::parseRequest
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return boolean
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        $pathInfo = trim($pathInfo, '/');

        if($pathInfo == '')
            return ['lk/producer/index', []];
        
        return false;
    }
}
?>