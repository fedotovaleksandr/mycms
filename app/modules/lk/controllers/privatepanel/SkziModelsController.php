<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\controllers\privatepanel;

//use yii\web\Controller;
use app\modules\privatepanel\components\PrivateController;

/**
 * @link PrivateController
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class SkziModelsController extends PrivateController
{
    protected $_modelName = 'app\modules\lk\models\SkziModels';
    
    public function actionReload()
    {
      \app\modules\lk\models\SkziModels::updateModels();
      $this->redirect('/private/tachograph-models/admin');
    }

}
