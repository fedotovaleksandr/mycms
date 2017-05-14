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
class MotorCompanyController extends Controller
{
    public $layout = "producer";

    private function checkRights($action)
    {

        if (\Yii::$app->user2->isGuest) {
            return $this->redirect(\Yii::$app->user2->loginUrl);
        }
        if (\Yii::$app->user2->getIdentity()->type !== \app\models\TUserIndentity::MOTOR_COMPANY) {
            throw new \yii\web\HttpException(403, 'Доступ запрещён');
        }
        if (\Yii::$app->user2->checkRights($action) === false) {
            throw new \yii\web\HttpException(403, 'Доступ запрещён');
        }
        return TRUE;
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user2->isGuest) {
            return $this->redirectAuthUser();
        }
        $model = new \app\modules\lk\models\AuthForm();
        if (\Yii::$app->request->getIsPost()) {
            $model->load(\Yii::$app->request->post());
            if ($model->auth()) {
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
        return $this->redirect('/lk/motor-company/login/');
    }

    private function redirectAuthUser()
    {
        switch (\Yii::$app->user2->getIdentity()->type) {
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

    public function actionIndex()
    {
        if($this->checkRights('index') !== TRUE)
        {
            return;
        }
        //$client = \Yii::$app->webservice->getClient('skziWsdl');//$client = $this->getClient('skziWsdl');
        return $this->render('index', []);
    }

    public function actionTahos()
    {
        if($this->checkRights('tahos') !== TRUE)
        {
            return;
        }
        $table = 'tachograph-atp';
        $userId = \Yii::$app->user2->getId();
        $errorMsg = FALSE;
        $viewTableFields = \app\modules\lk\models\TableSettings::getTableFieldList($userId, $table);
        $filters = \app\modules\lk\components\Fields::getFilters($table);
        $helper = new \app\modules\lk\components\MotorCompanyHelper();
        $pageLimit = $helper->getPageLimit($userId, $table);
        $page = \Yii::$app->request->get('page', 1) - 1 ;
        $rows = $helper->findTachoByFilter($table, $pageLimit, $page * $pageLimit, $debagInfo);
        if($rows === FALSE)
        {
            $errorMsg = $helper->getErrorMsg();
        }
        $pagination = new \yii\data\Pagination([
            'pageSize' => $pageLimit,
            'totalCount' => $helper->getTotalCount(),
            'page' => $page
        ]);
        $list = $helper->processBeforeView($rows, $viewTableFields);
        //var_dump($rows);
        $allFields = \app\modules\lk\components\Fields::getFields($table);
        $userFileds = \app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), $table);
        $model = new \app\modules\lk\models\motorcompany\CarForm();
        $skziList = [];
        foreach($rows as $row)
        {
            if(isset($row->skziId))
            {
                $skziList[$row->skziId] = $helper->findSkziById($row->skziId);
            }
        }

        foreach($viewTableFields as $fieldKey => $option)
        { 
          if(!isset($allFields[$fieldKey]))
          {
            unset($viewTableFields[$fieldKey]);
          }
        }
        return $this->render('tachograph-table', [
            'list' => $list,
            'rows' => $rows,
            'pagination' => $pagination,
            'viewTableFields' => $viewTableFields,
            'errorMsg' => $errorMsg,
            'debagInfo' => $debagInfo,
            'filters' => $filters,
            'objects' => $rows,
            'allFields' => $allFields,
            'userFileds' => $userFileds,
            'model' => $model,
            'skziList' => $skziList,
            'table' => $table
        ]);

    }

    public function actionHelp()
    {
        if ($this->checkRights('docs') !== TRUE) {
            return;
        }
        return $this->render('zaglushka',
            []);
    }
    
    /**
     * сохранение настроек для таблицы
     * без отображения
     * @return array
     */
    public function actionTable()
    {
      if($this->checkRights('table') !== TRUE)
      {
        return;
      }
      //
      if(\Yii::$app->request->isPost)
      {
        $data = \Yii::$app->request->post();
        $model = \app\modules\lk\models\TableSettings::findOne(['table' => $data['table'], 'id_user' => \Yii::$app->user2->getId()]);
        if($model)
        {
          $model->setScenario('update');
        }
        else
        {
          $model = new \app\modules\lk\models\TableSettings();
          $model->setScenario('insert');
        }
        $model->table = $data['table'];
        $allFields = \app\modules\lk\components\Fields::getFields($model->table);
        $model->view_fields = array();
        $tempArray = [];
        foreach($data as $key => $value)
        {
          if(array_key_exists($key, $allFields))
          {
            $tempArray[] = $key;
          }
        }
        $model->view_fields = $tempArray;
        if($model->save())
        {

        }
      }
      return $this->redirect(\Yii::$app->request->post('return-url', '/lk/motor-company/'));
    }
    
    /**
     * устанавливает количество строк в странице
     * @return 
     */
    public function actionCount()
    {
      if($this->checkRights('count') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = \Yii::$app->request->post();
        $model = \app\modules\lk\models\TableSettings::findOne(['table' => $data['table'], 'id_user' => \Yii::$app->user2->getId()]);
        if($model)
        {
          $model->setScenario('update');
        }
        else
        {
          $model = new \app\modules\lk\models\TableSettings();
          $model->setScenario('insert');
        }
        if(isset($data['count']))
        {
          $model->page_limit = (int)$data['count'];
        }
        return ['error' => !$model->save(), 'html' => \yii\helpers\Html::errorSummary($model)];
      }
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
      $model->from = \app\modules\lk\models\Question::FROM_MOTOR_COMPANY;//производитель тахографов
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
          'model' => $model
      ]);
    }
    
    /**
     * добавление автомобиля
     * @return type
     */
    public function actionAddCar()
    {
      if($this->checkRights('add-car') !== TRUE)
      {
        return;
      }
      $model = new \app\modules\lk\models\motorcompany\CarForm();
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if(\Yii::$app->request->isPost)
      {
        $model->load(\Yii::$app->request->post());
        if(!$model->validate())
        {
          return ['error' => true, 'errorList' => $model->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($model)];
        }
        if($model->save($debagInfo))
        {
          return ['html' => 'Автомобиль добавлен', 'error' => false];
        }
        else
        {
          return ['error' => true, 'errorList' => $model->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($model)];
        }
        return ['error' => true];
      }
      return ['error' => TRUE];
    }
    
    public function actionDriversCards()
    {
      if($this->checkRights('drivers-cards') !== TRUE)
      {
        return;
      }
      $table = 'driver-card-atp';
      $userId = \Yii::$app->user2->getId();
      $errorMsg = FALSE;
      $viewTableFields = \app\modules\lk\models\TableSettings::getTableFieldList($userId, $table);
      $filters = \app\modules\lk\components\Fields::getFilters($table);
      $helper = new \app\modules\lk\components\MotorCompanyHelper();
      $pageLimit = $helper->getPageLimit($userId, $table);
      $page = \Yii::$app->request->get('page', 1) - 1 ;
      $rows = $helper->findDriverCard($table, $pageLimit, $page * $pageLimit, $debagInfo);
      if($rows === FALSE)
      {
          $errorMsg = $helper->getErrorMsg();
      }
      $pagination = new \yii\data\Pagination([
          'pageSize' => $pageLimit,
          'totalCount' => $helper->getTotalCount(),
          'page' => $page
      ]);
      $list = $helper->processBeforeView($rows, $viewTableFields);
      //var_dump($rows);
      $allFields = \app\modules\lk\components\Fields::getFields($table);
      $userFileds = \app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), $table);

      foreach($viewTableFields as $fieldKey => $option)
      { 
        if(!isset($allFields[$fieldKey]))
        {
          unset($viewTableFields[$fieldKey]);
        }
      }
      return $this->render('drivers-cards', [
          'list' => $list,
          'rows' => $rows,
          'pagination' => $pagination,
          'viewTableFields' => $viewTableFields,
          'errorMsg' => $errorMsg,
          'debagInfo' => $debagInfo,
          'filters' => $filters,
          'objects' => $rows,
          'allFields' => $allFields,
          'userFileds' => $userFileds,
          'table' => $table,
          'soonExpiresInfo' => $helper->getSoonExpiresDriverCards()
      ]);
    }
}