<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * The default controller
 *
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class ControllerController extends Controller
{
  public $layout = "producer";
  public function behaviors()
  {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['logout'],
              'rules' => [
                  [
                      'actions' => ['index'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'logout' => ['post'],
              ],
          ],
      ];
  }
  
  private function checkRights($action)
  {

    if(\Yii::$app->user2->isGuest)
    {
      return $this->redirect(\Yii::$app->user2->loginUrl);
    }
    if(\Yii::$app->user2->getIdentity()->type !== \app\models\TUserIndentity::CONTROLLER_TYPE)
    {
      throw new \yii\web\HttpException(403, 'Доступ запрещён');
    }
    if(\Yii::$app->user2->checkRights($action) === false)
    {
      throw new \yii\web\HttpException(403, 'Доступ запрещён');
    }
    return TRUE;
  }
  
  /**
   * Page of form
   * If the form is submitted, processes input values.
   * According to form settings, either saves data to db or sends to email, or both
   * @return string
   * @throws \yii\web\NotFoundHttpException if form is not found
   */
  public function actionIndex()
  {
    if($this->checkRights('index') !== TRUE)
    {
      return;
    }
    return $this->render('index', []);
  }
  
  public function actionDocs()
  {
    if($this->checkRights('docs') !== TRUE)
    {
      return;
    }
    return $this->render('zaglushka', 
            []);
  }
  
  public function actionHelp()
  {
    if($this->checkRights('docs') !== TRUE)
    {
      return;
    }
    return $this->render('zaglushka', 
            []);
  }
  
  public function actionQuestion()
  {
    if($this->checkRights('docs') !== TRUE)
    {
      return;
    }
    return $this->render('zaglushka', 
            []);
  }
  
}