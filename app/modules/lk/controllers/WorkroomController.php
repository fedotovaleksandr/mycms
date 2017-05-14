<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\lk\models\workroom;
use app\models\TUserIndentity;

/**
 * The default controller
 *
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class WorkroomController extends Controller
{
  public $layout = "workroom";
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
    return $this->redirect('/lk/workroom/login/');
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

  private function checkRights($action)
  {
    if(\Yii::$app->user2->isGuest)
    {
      return $this->redirect(\Yii::$app->user2->loginUrl);
    }
    if(\Yii::$app->user2->getIdentity()->type !== \app\models\TUserIndentity::WORKROOM_TYPE)
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
    //$client = \Yii::$app->webservice->getClient('skziWsdl');//$client = $this->getClient('skziWsdl');
    return $this->render('index', []);
  }

  
  /**
   * задать вопрос
   * @return type
   */
  public function actionQuestion()
  {
    if($this->checkRights('question') !== TRUE)
    {
      return;
    }
    $model = new \app\modules\lk\models\Question();
    $model->setScenario('insert');
    $model->from = \app\modules\lk\models\Question::FROM_WORKROOM;//производитель тахографов
    $status = FALSE;
    if(\Yii::$app->request->isPost)
    {
      $model->load(\Yii::$app->request->post());
      if($model->save())
      {
        $status = TRUE;
      }
    }
    else
    {
      $model->org_name = \Yii::$app->user2->getIdentity()->getOrgName();
      $model->name = \Yii::$app->user2->getIdentity()->getName();
    }
    return $this->render('question', [
        'status' => $status,
        'model' => $model,
    ]);
  }
  
  /**
   * Мои активизации
   */
  public function actionActivation()
  {
    if($this->checkRights('activation') !== TRUE)
    {
      return;
    }
    $activationForm = new workroom\ActivationForm();
    $activationForm->setScenario('insert');

    if(\Yii::$app->request->isPost)
    {

      //обработка данных из первой и второй формы
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $activationForm->attributes=\Yii::$app->request->post('ActivationForm');
      if(!$activationForm->validate('ActivationForm'))
      {
        return ['error' => true, 'errorList' => $activationForm->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($activationForm)];
      }
      $debagInfo = \Yii::$app->request->post('ActivationForm');
      if($activationForm->save($debagInfo))
      {
          var_dump($activationForm->save($debagInfo));
          die;
        return ['html' => 'Добавлено', 'error' => false];
      }
      return ['error' => true];
    }
    $helper = new \app\modules\lk\components\WorkroomHelper();
    $lastActivations = $helper->getLastActivations(\Yii::$app->user2->getId());
    return $this->render('activation', [
        'activationForm' => $activationForm,
        'lastActivations' => $lastActivations
    ]);
  }
  
  /**
   * архив активизаций
   * @return string
   */
  public function actionActivationArchive()
  {
    if($this->checkRights('activation-archive') !== TRUE)
    {
      return;
    }
	
    $helper = new \app\modules\lk\components\WorkroomHelper();
	 $table = 'activations';
      $userId = \Yii::$app->user2->getId();
      $errorMsg = FALSE;
      $viewTableFields = \app\modules\lk\models\TableSettings::getTableFieldList($userId, $table);
      $filters = \app\modules\lk\components\Fields::getFilters($table);
      $helper = new \app\modules\lk\components\WorkroomHelper();
      $pageLimit = $helper->getPageLimit($userId, $table);
      $page = \Yii::$app->request->get('page', 1) - 1 ;
      $rows = $helper->getCards($userId, $pageLimit,$table);
      $pagination = new \yii\data\Pagination([
          'pageSize' => $pageLimit,
          'totalCount' => $helper->getTotalCount(),
          'page' => $page
      ]);
      $archive = $helper->getActivationArchive(\Yii::$app->user2->getId(), \Yii::$app->request->get());
      $allFields = \app\modules\lk\components\Fields::getFields('activations');
      $userFileds = \app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), 'skzi');
    return $this->render('activation-archive', [
        'archive' => $archive,
        'pagination' => $pagination,
        'viewTableFields' => $viewTableFields,
        'errorMsg' => $errorMsg,
        'filters' => $filters,
        'objects' => $rows,
        'allFields' => $allFields,
        'userFileds' => $userFileds,
        //'model' => $model
    ]);
  }
  
  /**
   * Карты и сроки их действия
   * @return type
   */
  public function actionCards()
  {
    if($this->checkRights('cards') !== TRUE)
    {
      return;
    }
    $helper = new \app\modules\lk\components\WorkroomHelper();

      $table = 'cards';
      $userId = \Yii::$app->user2->getId();
      $errorMsg = FALSE;
      $viewTableFields = \app\modules\lk\models\TableSettings::getTableFieldList($userId, $table);
      $filters = \app\modules\lk\components\Fields::getFilters($table);
      $helper = new \app\modules\lk\components\WorkroomHelper();
      $pageLimit = $helper->getPageLimit($userId, $table);
      $page = \Yii::$app->request->get('page', 1) - 1 ;
      $rows = $helper->getCards($userId, $pageLimit,$table);
      if(count($rows) == 0)
      {
         // $errorMsg = $helper->getErrorMsg();
      }
      $pagination = new \yii\data\Pagination([
          'pageSize' => $pageLimit,
          'totalCount' => $helper->getTotalCount(),
          'page' => $page
      ]);
      $cards = [];//$helper->processBeforeView($rows, $viewTableFields);
      $allFields = \app\modules\lk\components\Fields::getFields('cards');
      $userFileds = \app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), 'skzi');
    return $this->render('cards',[
        'cards' => $cards,
        'pagination' => $pagination,
        'viewTableFields' => $viewTableFields,
        'errorMsg' => $errorMsg,
        'filters' => $filters,
        'objects' => $rows,
        'allFields' => $allFields,
        'userFileds' => $userFileds,
    ]);
  }
  
  /**
   * Информация о мастерской
   */
  public function actionInfo()
  {
    if($this->checkRights('info') !== TRUE)
    {
      return;
    }
    $helper = new \app\modules\lk\components\WorkroomHelper();
    if(\Yii::$app->request->isPost)
    {
      //обработка данных из  формы
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $infoEditForm = new workroom\InfoForm();
      $infoEditForm->load(\Yii::$app->request->post());
      if(!$activationForm->validate())
      {
        return ['error' => true, 'errorList' => $infoEditForm->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($infoEditForm)];
      }
      if($infoEditForm->update($debagInfo))
      {
        return ['html' => 'Добавлено', 'error' => false];
      }
      return ['error' => true];
    }
    $workRoomList = $helper->getWorkRoomList(\Yii::$app->user2->getId())->return->addresses;
    $infoEditFormList = array();
    foreach($workRoomList as $key => $workroom)
    {
      $infoEditFormList[$key] = new workroom\InfoForm();
      $infoEditFormList[$key]->loadObject($workroom);
    }
    return $this->render('info', [
        'workRoomList' => $workRoomList,
        'infoEditFormList' => $infoEditFormList,
    ]);
  }
  
  public function actionHelp()
  {
    if($this->checkRights('help') !== TRUE)
    {
      return;
    }
    $sections = \app\modules\lk\models\HelpSections::getSecttionList(\app\modules\lk\models\HelpSections::WORKROOM_TYPE, 0);
    $pages = \app\modules\lk\models\HelpPages::getPageList(\app\modules\lk\models\HelpSections::WORKROOM_TYPE);
    return $this->render('help', [
        'sections' => $sections,
        'pages' => $pages,
    ]);
  }
  
  public function actionHelpView()
  {
    if($this->checkRights('help') !== TRUE)
    {
      return;
    }
    $page = \app\modules\lk\models\HelpPages::findOne(['id' => (int)\Yii::$app->request->get('id', 0)]);
    if($page)
    {
      $section = \app\modules\lk\models\HelpSections::findOne(['id' => $page->id_section, 'id_type' => \app\modules\lk\models\HelpSections::WORKROOM_TYPE]);
      if($section)
      {
        return $this->render('help-view', [
            'page' => $page,
            'section' => $section
        ]);
      }
      else
      {
        throw new \yii\web\HttpException(403, 'Доступ запрещён');
      }
    }
    throw new \yii\web\HttpException(404, 'Страница не найдена');
  }
}