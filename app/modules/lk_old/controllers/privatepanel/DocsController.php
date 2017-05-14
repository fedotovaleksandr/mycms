<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\controllers\privatepanel;

//use yii\web\Controller;
use app\modules\privatepanel\components\PrivateController;
use app\modules\privatepanel\components\PrivateModelAdmin;
use app\modules\privatepanel\components\TreeActiveDataProvider;

/**
 * The class for constants in back end of Alchemy CMS
 * @see \app\models\Constants
 * @link PrivateController
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class DocsController extends PrivateController
{
    protected $_modelName = 'app\modules\lk\models\producer\Docs';
    
    public function actionCheck()
    {
      \yii\helpers\Url::remember(\yii\helpers\Url::current(), 'private-check-page');
      $pageLimit = 50;
      $query = \app\modules\lk\models\producer\Docs::find()->where(['status' => 0]);
      $pagination = new \yii\data\Pagination(
          [
              'totalCount' => $query->count(),
              'pageSize' => $pageLimit
              ]);
      $models = $query->offset($pagination->offset)
                      ->limit($pagination->limit)
                      ->all();
      return $this->render('moderation', array(
            'pagination' => $pagination,
            'models' => $models
        ));
    }
    
    public function actionDeactivate()
    {
      $request = \Yii::$app->request;
      if($request->isPost)
      {
        $document = \app\modules\lk\models\producer\Docs::findOne(['id' => $request->post('id')]);
        if($document)
        {
          $document->status = \app\modules\lk\models\producer\Docs::BAD_DOC;
          $document->moderatorComment = $request->post('moderatorComment');
          $document->save();
        }
      }
      return $this->redirect(\yii\helpers\Url::previous('private-check-page'));
    }
    
    /**
     * активация документа
     */
    public function actionActivate()
    {
      $id = \Yii::$app->request->get('id');
      $document = \app\modules\lk\models\producer\Docs::findOne(['id' => $id]);
      if($document)
      {
        $document->status = \app\modules\lk\models\producer\Docs::ACTIVE_DOC;
        $document->save();
      }
      return $this->redirect(\yii\helpers\Url::previous('private-check-page'));
    }
    
    
}