<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\TUserIndentity;

/**
 * The default controller
 *
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class CardProducerController extends Controller
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
    if(\Yii::$app->user2->getIdentity()->type !== \app\models\TUserIndentity::CARD_PRODUCER)
    {
      throw new \yii\web\HttpException(403, 'Доступ запрещён');
    }
    if(\Yii::$app->user2->checkRights($action) === false)
    {
      throw new \yii\web\HttpException(403, 'Доступ запрещён');
    }
    return TRUE;
  }
  
  public function actionLogin()
  {
    if(!\Yii::$app->user2->isGuest)
    {
      return $this->redirectAuthUser();
    }
    $model = new \app\modules\lk\models\AuthForm();
    if(\Yii::$app->request->getIsPost())
    {
      $model->load(\Yii::$app->request->post());
      if($model->auth())
      {
        return $this->redirectAuthUser();
      }
    }
    $model->login = '';
    $model->password = '';
    return $this->render('login', ['model' => $model]);
  }
  
  public function actionOut()
  {
    \Yii::$app->user2->logout(TRUE);
    return $this->redirect('/lk/card-producer/login/');
  }
  
  private function redirectAuthUser()
  {
    switch(\Yii::$app->user2->getIdentity()->type)
    {
      case TUserIndentity::MANUFACTURE_TYPE:
        return $this->redirect('/lk/producer/');
        break;
      case TUserIndentity::MOTOR_COMPANY:
        return $this->redirect('/lk/motor-company/');
        break;
      case TUserIndentity::CARD_PRODUCER:
        return $this->redirect('/lk/card-producer/');
        break;
      case TUserIndentity::CONTROLLER_TYPE:
        return $this->redirect('/lk/controller/');
        break;
      case TUserIndentity::WORKROOM_TYPE:
        return $this->redirect('/lk/workroom/');
        break;
    }
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
  
  public function actionCards()
  {
    if($this->checkRights('cards') !== TRUE)
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