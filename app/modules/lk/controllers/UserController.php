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
class UserController extends Controller
{
  public $layout = "producer";
  
  public function actionLogin()
  {
      //var_dump(\Yii::$app->user2->getIdentity());

    if(!\Yii::$app->user2->isGuest)
    {
      return $this->redirectAuthUser();
    }
    $model = new \app\modules\lk\models\AuthForm();
    if(\Yii::$app->request->getIsPost())
    {
      $model->load(\Yii::$app->request->post());
      \Yii::$app->session->set('lk-password', $model->password);

      if($model->auth())
      {
        return $this->redirectAuthUser();
      }
    }
    $model->login = '';
    $model->password = '';
    return $this->render('login', ['model' => $model]);
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
  
  public function actionLogout()
  {
    \Yii::$app->user2->logout(TRUE);
    return $this->redirect(\Yii::$app->user2->loginUrl);
  }
  
  //страница скачивания ssl сертификата
  public function actionSsl()
  {
    $model = new \app\modules\lk\models\AuthForm();
    if(\Yii::$app->request->getIsPost())
    {
      $model->load(\Yii::$app->request->post());
      $model->getSSL();
    }
    $model->login = '';
    $model->password = '';
    return $this->render('need_ssl', ['model' => $model]);
  }
  
  public function actionEdit()
  {
    if(\Yii::$app->user2->isGuest)
    {
      return $this->redirect(\Yii::$app->user2->loginUrl);
    }
    $model = new \app\modules\lk\models\UserForm;
    if(\Yii::$app->request->getIsPost())
    {
      $model->load(\Yii::$app->request->post());
      if($model->validate())
      {
        $model->update();
      }
    }
    else
    {
      $model->setAttributes(\Yii::$app->user2->getIdentity()->getAttributes());
    }
    //$model->login = '';
    $model->password = '';
    $model->newPassword = '';
    return $this->render('edit', ['model' => $model]);
  }
  
}