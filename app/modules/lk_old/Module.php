<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk;

use yii\helpers\ArrayHelper;

/**
 * The form module for Alchemy CMS
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\lk\controllers';
    
    public function init()
    {
        parent::init();
        // custom initialization code goes here
        self::registerTranslations();
    }    
    
    /**
     * Registers the translations
     */
    public static function registerTranslations()
    {
        //
    }
    
    /**
     * Returns list of handlers.
     * @see \app\models\Page::getHandlers
     * @return array
     */
    public function getHandlers()
    {
        return [
            //'lk/default/index' => 'Личный кабинет',
        ];
    }
    
    /**
     * Returns list of additional url rules.
     * @see \app\models\Page::getHandlerRules
     * @return array
     */
    public function getHandlerRules()
    {
//        $result = ['lk/default/index' => [
//            ['class' => 'app\\modules\\lk\\components\\UrlRule'],
//        ]];
        
        return [];
    }
    
    /**
     * Returns menu items for main menu for back end
     * @see \app\modules\privatepanel\Module::getMenus
     * @return array
     */
    public function privateMenuLinks()
    {
        return [
          'docs' => [
              'label' => 'Документы',
              'url' => '#',
              'items' => [
                  ['label' => 'Документы', 'url'=> ['/private/docs/admin'], 'visible' => \yii::$app->user->can('/private/docs/admin')],
                  ['label' => 'Модерация', 'url'=> ['/private/docs/check'], 'visible' => \yii::$app->user->can('/private/docs/check')]
                ]
                ],
          'models' => [
              'label' => 'Модели оборудования',
              'url' => '#',
              'items' => [
                  ['label' => 'Тахографы ', 'url'=> ['/private/tachograph-models/admin'], 'visible' => \yii::$app->user->can('/private/tachograph-models/admin')],
                  ['label' => 'СКЗИ', 'url'=> ['/private/skzi-models/admin'], 'visible' => \yii::$app->user->can('/private/skzi-models/admin')],
                  ['label' => 'Карты', 'url'=> ['/private/card-models/admin'], 'visible' => \yii::$app->user->can('/private/card-models/admin')]
                ]
                ],
          'help' => [
              'label' => 'Помощь в использовании',
              'url' => '#',
              'items' => [
                  ['label' => 'Разделы', 'url'=> ['/private/help-sections/admin'], 'visible' => \yii::$app->user->can('/private/help-sections/admin')],
                  ['label' => 'Страницы', 'url'=> ['/private/help-pages/admin'], 'visible' => \yii::$app->user->can('/private/help-pages/admin')]
                ]
                ],
        ];
    }
    
    /**
     * Returns additional controllers for back end
     * @see \app\modules\privatepanel\Module
     * @return array
     */
    public function privateControllerMap()
    {
        return [
            'docs' => '\app\modules\lk\controllers\privatepanel\DocsController',
            'skzi-models' => '\app\modules\lk\controllers\privatepanel\SkziModelsController',
            'tachograph-models' => '\app\modules\lk\controllers\privatepanel\TachographModelsController',
            'card-models' => '\app\modules\lk\controllers\privatepanel\CardModelsController',
            'help-sections' => '\app\modules\lk\controllers\privatepanel\HelpSectionsController',
            'help-pages' => '\app\modules\lk\controllers\privatepanel\HelpPagesController'
        ];
    }
    
    
}
