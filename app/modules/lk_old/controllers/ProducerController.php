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
class ProducerController extends Controller
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

    public function actionOut()
    {
      \Yii::$app->user2->logout(TRUE);
      return $this->redirect('/lk/user/login/');
    }
    
    private function checkRights($action)
    {
      
      if(\Yii::$app->user2->isGuest)
      {
        return $this->redirect(\Yii::$app->user2->loginUrl);
      }
      if(\Yii::$app->user2->getIdentity()->type !== \app\models\TUserIndentity::MANUFACTURE_TYPE)
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
      //layout = "producer";$this->layout = "producer";
      if($this->checkRights('index') !== TRUE)
      {
        return;
      }
      //$soap = \Yii::$app->webservice;
      //var_dump($soap->getFunctions());
      //$client = \Yii::$app->webservice->getClient('skziWsdl');//$client = $this->getClient('skziWsdl');
      //var_dump($client->__getTypes());
      //$result = $client->findById(['id' => 1]);
      //echo $client->__getLastResponse();
      return $this->render('index', []);
    }
    
    /**
     * поиск/список тахографов
     */
    public function actionTachograph()
    {
      if($this->checkRights('tachograph') !== TRUE)
      {
        return;
      }
      $table = 'tachograph';
      $userId = \Yii::$app->user2->getId();
      $errorMsg = FALSE;
      $viewTableFields = \app\modules\lk\models\TableSettings::getTableFieldList($userId, $table);
      $filters = \app\modules\lk\components\Fields::getFilters($table);
      $helper = new \app\modules\lk\components\ProducerHelper();
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
      $allFields = \app\modules\lk\components\Fields::getFields('tachograph');
      $userFileds = \app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), 'tachograph');
      $model = new \app\modules\lk\models\producer\TachographForm();
      $skziList = [];
      foreach($rows as $row)
      {
        if(isset($row->skziId))
        {
          $skziList[$row->skziId] = $helper->findSkziById($row->skziId);
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
      ]);

    }
    
    /**
     * поиск/список СКЗИ
     */
    public function actionSkzi()
    {
      if($this->checkRights('skzi') !== TRUE)
      {
        return;
      }
      $table = 'skzi';
      $userId = \Yii::$app->user2->getId();
      $errorMsg = FALSE;
      $viewTableFields = \app\modules\lk\models\TableSettings::getTableFieldList($userId, $table);
      $filters = \app\modules\lk\components\Fields::getFilters($table);
      $helper = new \app\modules\lk\components\ProducerHelper();
      $pageLimit = $helper->getPageLimit($userId, $table);
      $page = \Yii::$app->request->get('page', 1) - 1 ;
      $rows = $helper->findSkziByFilter($table, $pageLimit, $page * $pageLimit, $debagInfo);
      if(count($rows) == 0)
      {
        $errorMsg = $helper->getErrorMsg();
      }
      $pagination = new \yii\data\Pagination([
            'pageSize' => $pageLimit,
            'totalCount' => $helper->getTotalCount(),
            'page' => $page
          ]);
      $list = $helper->processBeforeView($rows, $viewTableFields);
      $allFields = \app\modules\lk\components\Fields::getFields('skzi');
      $userFileds = \app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), 'skzi');
      $model = new \app\modules\lk\models\producer\SkziForm();
      return $this->render('skzi-table', [
          'list' => $list,
          'pagination' => $pagination,
          'viewTableFields' => $viewTableFields,
          'errorMsg' => $errorMsg,
          'debagInfo' => $debagInfo,
          'filters' => $filters,
          'objects' => $rows,
          'allFields' => $allFields,
          'userFileds' => $userFileds,
          'model' => $model
      ]);
    }
    
    /**
     * внести в стоп-лист из файла
     */
    public function actionStopFile()
    {
      if($this->checkRights('stop') !== TRUE)
      {
        return;
      }
      $status = '';
      if(\Yii::$app->request->isPost)
      {
        $file = \yii\web\UploadedFile::getInstanceByName('stop');
        if($file)
        {
          $helper = new \app\modules\lk\components\ProducerHelper();
          $result = $helper->addStop($file);
          $status = is_string($result) ? $result : 'При добавлении произошла ошибка';
        }
        else
        {
          $status = "Файл не выбран";
        }
      }
      return $this->render('stop', [
          'status' => $status
      ]);
    }
    
    /**
     * внести изменения
     */
    public function actionChange()
    {
      if($this->checkRights('change') !== TRUE)
      {
        return;
      }
      return 'В разработке';
    }
    
    /**
     * внести в архив
     */
    public function actionArchive()
    {
      if($this->checkRights('archive') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        $id = \Yii::$app->request->get('id');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        if(\Yii::$app->request->post('type') == 'skzi')
        {
          $object = $helper->findSkziById($id);
          if(!$object)
          {
            return ['error' => TRUE, 'html' => 'СКЗИ не найден'];
          }
          $result = $helper->archiveSkzi($id);
          if($result === TRUE)
          {
            return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." архивирован"];
          }
          return ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не архивирован - ".print_r($result, TRUE)];
        }
        elseif(\Yii::$app->request->post('type') == 'tachograph')
        {
          $object = $helper->findTachographById($id);
          if(!$object)
          {
            return ['error' => TRUE, 'html' => 'Тахограф не найден'];
          }
          $result = $helper->archiveTachograph($id);
          if($result === TRUE)
          {
            return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." архивирован"];
          }
          return ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не архивирован - ".print_r($result, TRUE)];
        }
        return ['error' => TRUE, 'html' => "Ошибка"];
      }
    }
    
    /**
     * внести в архив
     */
    public function actionUnarchive()
    {
      if($this->checkRights('archive') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        $id = \Yii::$app->request->get('id');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        if(\Yii::$app->request->post('type') == 'skzi')
        {
          $object = $helper->findSkziById($id);
          if(!$object)
          {
            return ['error' => TRUE, 'html' => 'СКЗИ не найден'];
          }
          $operationResult = $helper->unArchiveSkzi($id);
          if($operationResult === TRUE)
          {
            return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." разархивирован"];
          }
          return ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не разархивирован - ".print_r($operationResult, TRUE)];
        }
        elseif(\Yii::$app->request->post('type') == 'tachograph')
        {
          $object = $helper->findTachographById($id);
          if(!$object)
          {
            return ['error' => TRUE, 'html' => 'Тахограф не найден'];
          }
          $operationResult = $helper->unArchiveTachograph($id);
          if($operationResult === TRUE)
          {
            return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." разархивирован"];
          }
          return ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не разархивирован - ".print_r($operationResult, TRUE)];
        }
        return ['error' => TRUE, 'html' => "Ошибка"];
      }
    }
    
    public function actionStop()
    {
      if($this->checkRights('stop') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        $id = \Yii::$app->request->get('id');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        if(\Yii::$app->request->post('type') == 'skzi')
        {
            $operationResult = $helper->stopSkzi($id);
			$object = $helper->findSkziById($id);
            if(!$object)
            {
              return ['error' => TRUE, 'html' => 'СКЗИ не найден'];
            }
			if($operationResult === TRUE)
			{
				return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." добавлен в стоп-лист"];
			}
			else
			{
				return ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не добавлен в стоп-лист - ".print_r($operationResult, TRUE)];
			}
        }
        elseif(\Yii::$app->request->post('type') == 'tachograph')
        {         
          $operationResult = $helper->stopTachograph($id);
          $object = $helper->findTachographById($id);
          if(!$object)
          {
            return ['error' => TRUE, 'html' => 'Тахограф не найден'];
          }
          if($operationResult === TRUE)
          {
              return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." добавлен в стоп-лист"];
          }
          else
          {
              return ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не добавлен в стоп-лист - ".print_r($operationResult, TRUE)];
          }
        }
        return ['error' => TRUE, 'html' => "Ошибка"];
      }
    }
    
    public function actionUnstop()
    {
      if($this->checkRights('stop') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        $id = \Yii::$app->request->get('id');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        if(\Yii::$app->request->post('type') == 'skzi' && $helper->unStopSkzi($id))
        {
          $object = $helper->findSkziById($id);
          return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." удалён из стоп-листа"];
        }
        elseif(\Yii::$app->request->post('type') == 'tachograph' && $helper->unStopTachograph($id))
        {
          $object = $helper->findTachographById($id);
          return ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." удалён из стоп-листа"];
        }
        return ['error' => TRUE, 'html' => "Ошибка"];
      }
    }
    
    /**
     * Добавление партии Тахографов
     * @return type
     */
    public function actionAddBatchTachograph()
    {
      if($this->checkRights('add-tachograph') !== TRUE)
      {
        return;
      }
      $status = '';
      $messages = [];
      if(\Yii::$app->request->isPost)
      {
        $file = \yii\web\UploadedFile::getInstanceByName('export');
        if($file)
        {
          $helper = new \app\modules\lk\components\ProducerHelper();
          $result = $helper->addBatchTacho($file);
          if(is_array($result))
          {
            $messages = $result;
            $status = '';
          }
          else
          {
            $status = is_string($result) ? $result : 'Произошла ошибка';
          }
        }
        else
        {
          $status = "Файл не выбран";
        }
      }
      return $this->render('add-tachograph', ['status' => $status, 'messages' => $messages]);
    }
    
    /**
     * Добавление партии СКЗИ
     * @return type
     */
    public function actionAddBatchSkzi()
    {
      if($this->checkRights('add-skzi') !== TRUE)
      {
        return;
      }
      $status = '';
      $messages = [];
      if(\Yii::$app->request->isPost)
      {
        $file = \yii\web\UploadedFile::getInstanceByName('export');
        if($file)
        {
          $helper = new \app\modules\lk\components\ProducerHelper();
          $result = $helper->addBatchSkzi($file);
          if(is_array($result))
          {
            $messages = $result;
            $status = '';
          }
          else
          {
            $status = is_string($result) ? $result : 'Произошла ошибка';
          }
        }
        else
        {
          $status = "Файл не выбран";
        }
      }
      return $this->render('add-skzi', ['status' => $status, 'messages' => $messages]);
    }
    
    public function actionArchiveBatch()
    {
      if($this->checkRights('archive') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        $result = [];
        foreach(\Yii::$app->request->post('id') as $id)
        {
          
          if(\Yii::$app->request->post('type') == 'skzi')
          {
            $object = $helper->findSkziById($id);
            if(!$object)
            {
              $result[$id] = ['error' => TRUE, 'html' => 'СКЗИ не найден'];
              continue;
            }
            $operationResult = $helper->archiveSkzi($id);
            if($operationResult === TRUE)
            {
              $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." архивирован"];
            }
            else
            {
              $result[$id] = ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не архивирован - ".print_r($operationResult, TRUE)];
            }
          }
          elseif(\Yii::$app->request->post('type') == 'tachograph')
          {
            $object = $helper->findTachographById($id);
            if(!$object)
            {
              $result[$id] = ['error' => TRUE, 'html' => 'Тахограф не найден'];
              continue;
            }
            $operationResult = $helper->archiveTachograph($id);
            if($operationResult === TRUE)
            {
              $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." архивирован"];
            }
            else
            {
              $result[$id] = ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не архивирован - ".print_r($operationResult, TRUE)];
            }
          }
        }
        return $result;
      }
    }
    
    public function actionUnarchiveBatch()
    {
      if($this->checkRights('archive') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        $result = [];
        foreach(\Yii::$app->request->post('id') as $id)
        {
          if(\Yii::$app->request->post('type') == 'skzi')
          {
            $object = $helper->findSkziById($id);
            if(!$object)
            {
              $result[$id] = ['error' => TRUE, 'html' => 'СКЗИ не найден'];
              continue;
            }
            $operationResult = $helper->unArchiveSkzi($id);
            if($operationResult === TRUE)
            {
              $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." разархивирован"];
            }
            else
            {
              $result[$id] = ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не разархивирован - ".print_r($operationResult, TRUE)];
            }
          }
          elseif(\Yii::$app->request->post('type') == 'tachograph')
          {
            $object = $helper->findTachographById($id);
            if(!$object)
            {
              $result[$id] = ['error' => TRUE, 'html' => 'СКЗИ не найден'];
              continue;
            }
            $operationResult = $helper->unArchiveTachograph($id);
            if($operationResult === TRUE)
            {
              $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." разархивирован"];
            }
            else
            {
              $result[$id] = ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не разархивирован - ".print_r($operationResult, TRUE)];
            }
          }
        }
        return $result;
      }
    }
    
    public function actionStopBatch()
    {
      if($this->checkRights('stop') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        $result = [];
        foreach(\Yii::$app->request->post('id') as $id)
        {
          if(\Yii::$app->request->post('type') == 'skzi')
          {
            $object = $helper->findSkziById($id);
            if(!$object)
            {
              $result[$id] = ['error' => TRUE, 'html' => 'СКЗИ не найден'];
              continue;
            }
            $operationResult = $helper->stopSkzi($id);
            if($operationResult === TRUE)
            {
              $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." добавлен в стоп-лист"];
            }
            else
            {
              $result[$id] = ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не добавлен в стоп-лист - ".print_r($operationResult, TRUE)];
            }
          }
          elseif(\Yii::$app->request->post('type') == 'tachograph')
          {
            $object = $helper->findTachographById($id);
            if(!$object)
            {
              $result[$id] = ['error' => TRUE, 'html' => 'СКЗИ не найден'];
              continue;
            }
            $operationResult = $helper->stopTachograph($id);
            if($operationResult === TRUE)
            {
              $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." добавлен в стоп-лист"];
            }
            else
            {
              $result[$id] = ['error' => TRUE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." не добавлен в стоп-лист - ".print_r($operationResult, TRUE)];
            }
          }
        }
        return $result;
      }
    }
    
    public function actionDelBatch()
    {
      if($this->checkRights('archive') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        $result = [];
        foreach(\Yii::$app->request->post('id') as $id)
        {
          if(\Yii::$app->request->post('type') == 'skzi' && $helper->delSkzi($id))
          {
            $object = $helper->findSkziById($id);
            $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." утилизирован"];
          }
          elseif(\Yii::$app->request->post('type') == 'tachograph' && $helper->delTachograph($id))
          {
            $object = $helper->findTachographById($id);
            $result[$id] = ['error' => FALSE, 'html' => $object->equipTypeModel.' '.$object->serialNumber." утилизирован"];
          }
        }
        return $result;
      }
    }
    
    public function actionDelDocBatch()
    {
      if($this->checkRights('archive') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $helper = new \app\modules\lk\components\ProducerHelper();
        $result = [];
        foreach(\Yii::$app->request->post('id') as $id)
        {
          $doc = \app\modules\lk\models\producer\Docs::findOne([
              'id' => $id,
              'id_user' => \Yii::$app->user2->getId()
          ]);
          if($doc)
          {
            $doc->delete();
            if($doc->visible)
            {
              $result[$id] = ['error' => FALSE, 'html' => "Документ \"{$doc->name}\" не удалён"];
            }
            else
            {
              $result[$id] = ['error' => FALSE, 'html' => "Документ \"{$doc->name}\" удалён"];
            }
          }
          else
          {
            $result[$id] = ['error' => FALSE, 'html' => "Документ не найден"];
          }
        }
        return $result;
      }
    }
    
    public function actionViewDocs()
    {
      if($this->checkRights('view-docs') !== TRUE)
      {
        return;
      }
      $idModel = \Yii::$app->request->get('id-device', 0);
      $idDeviceType = \Yii::$app->request->get('device-type', 0);
      $docModel = new \app\modules\lk\models\producer\Docs;
      if(\Yii::$app->request->get('sort') && \Yii::$app->request->get('order') && in_array(\Yii::$app->request->get('sort'), $docModel->attributes()))
      {
        $docList = \app\modules\lk\models\producer\Docs::getDocuments(\Yii::$app->user2->getId(), $idModel, $idDeviceType, [\Yii::$app->request->get('sort') => (int)\Yii::$app->request->get('order')]);
      }
      else
      {
        $docList = \app\modules\lk\models\producer\Docs::getDocuments(\Yii::$app->user2->getId(), $idModel, $idDeviceType);
      }
      switch($idDeviceType)
      {
        case \app\modules\lk\models\producer\Docs::DEVICE_TACHOGRAPH:
          $object = \app\modules\lk\models\TachographModels::getObject($idModel);
          $name = $object ? "Тахограф \"{$object->model}\"" : '';
          break;
        case \app\modules\lk\models\producer\Docs::DEVICE_SKZI:
          $object = \app\modules\lk\models\SkziModels::getObject($idModel);
          $name = $object ? "СКЗИ \"{$object->model}\"" : '';
          break;
        case \app\modules\lk\models\producer\Docs::DEVICE_CARD:
          $object = \app\modules\lk\models\CardModels::getObject($idModel);
          $name = $object ? "Карта \"{$object->model}\"" : '';
          break;
      }
      return $this->render('view-docs',[
          'docList' => $docList,
          'object' => $object,
          'name' => $name,
          'deviceType' => $idDeviceType,
      ]);
    }
    
    /**
     * Оборудование и документы
     */
    public function actionDocs()
    {
      if($this->checkRights('docs') !== TRUE)
      {
        return;
      }
      $docModelList = \app\modules\lk\models\producer\Docs::getDocModels(\Yii::$app->user2->getId());
      $skziModels = \app\modules\lk\models\SkziModels::getModels(\Yii::$app->user2->getId());
      $tachographModels = \app\modules\lk\models\TachographModels::getModels(\Yii::$app->user2->getId());
      $cardModels = \app\modules\lk\models\CardModels::getModels(\Yii::$app->user2->getId());
      return $this->render('docs', 
              [
                  'docModelList' => $docModelList,
                  'skziModels' => $skziModels,
                  'tachographModels' => $tachographModels,
                  'cardModels' => $cardModels,
              ]);
    }
    
    public function actionAddDoc()
    {
      if($this->checkRights('add-doc') !== TRUE)
      {
        return;
      }
      $model = new \app\modules\lk\models\producer\Docs;
      $status = '';
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model->setScenario('insert');
        $model->load(\Yii::$app->request->post(), 'Docs');
        $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
        if($model->file && $model->uploadFile() && $model->save())
        {
          return ['error' => false, 'html' => 'Добавлено'];
        }
        else
        {
          return ['error' => TRUE, 'html' => \yii\helpers\Html::errorSummary($model)];
        }
      }
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
      return $this->redirect(\Yii::$app->request->post('return-url', '/lk/producer/'));
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
      $model->from = \app\modules\lk\models\Question::FROM_MANUFACTURE;//производитель тахографов
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
     * добавление skzi
     * @return type
     */
    public function actionAddSkzi()
    {
      if($this->checkRights('add-skzi') !== TRUE)
      {
        return;
      }
      $model = new \app\modules\lk\models\producer\SkziForm();
      $model->setScenario('insert');
      $status = '';
      $debagInfo = array();
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model->load(\Yii::$app->request->post());
        if(!$model->validate())
        {
          return ['error' => true, 'errorList' => $model->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($model)];
        }
        if($model->save($debagInfo))
        {
          return ['html' => 'Блок СКЗИ добавлен', 'error' => false];
        }
        else
        {
          return ['error' => true, 'errorList' => $model->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($model)];
        }
        return ['error' => true];
      }
    }
    
    /**
     * редактирование skzi
     * @return 
     */
    public function actionUpdateSkzi()
    {
      if($this->checkRights('update-skzi') !== TRUE)
      {
        return;
      }
      $model = new \app\modules\lk\models\producer\SkziForm();
      $model->setScenario('update');
      $debagInfo = [];
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if(\Yii::$app->request->isPost)
      {
        $model->load(\Yii::$app->request->post());
        if(!$model->validate())
        {
          return ['error' => true, 'errorList' => $model->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($model)];
        }
        if($model->update($model->id, $debagInfo))
        {
          return ['html' => 'Блок СКЗИ обновлён', 'error' => false];
        }
        return ['error' => true, 'errorList' => $model->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($model)];
      }
    }
    
    /**
     * добавление тахографа
     * @return type
     */
    public function actionAddTachograph()
    {
      if($this->checkRights('add-tachograph') !== TRUE)
      {
        return;
      }
      $modelTachograph = new \app\modules\lk\models\producer\TachographForm();
      $modelTachograph->setScenario('insert');
      $status = '';
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if(\Yii::$app->request->isPost)
      {
        $modelTachograph->load(\Yii::$app->request->post());
        if(!$modelTachograph->validate())
        {
          return ['error' => true, 'errorList' => $modelTachograph->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($modelTachograph)];
        }
        if($modelTachograph->save($debagInfo))
        {
          return ['html' => 'Тахограф добавлен', 'error' => false];
        }
        else
        {
          return ['error' => true, 'errorList' => $modelTachograph->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($modelTachograph)];
        }
        return ['error' => true];
      }
      return ['error' => TRUE];
    }
    
    /**
     * редактирование тахографа
     * @return type
     */
    public function actionUpdateTachograph()
    {
      if($this->checkRights('edit-tachograph') !== TRUE)
      {
        return;
      }
      $modelTachograph = new \app\modules\lk\models\producer\TachographForm();
      $modelTachograph->setScenario('update');
      $debagInfo = [];
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if(\Yii::$app->request->isPost)
      {
        $modelTachograph->load(\Yii::$app->request->post());
        if(!$modelTachograph->validate())
        {
          return ['error' => true, 'errorList' => $modelTachograph->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($modelTachograph)];
        }
        if($modelTachograph->update($modelTachograph->id, $debagInfo))
        {
          return ['html' => 'Тахограф обновлён', 'error' => false];
        }
        return ['error' => true, 'errorList' => $modelTachograph->getFirstErrors(), 'errorHtml' => \yii\helpers\Html::errorSummary($modelTachograph)];
      }
      return ['error' => TRUE];
    }
    
    public function actionModels()
    {
      \app\modules\lk\models\CardModels::getModels();
    }
    
    public function actionFindSkzi()
    {
      if(\Yii::$app->request->get('serialNumber'))
      {
        $helper = new \app\modules\lk\components\ProducerHelper();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $list = $helper->processBeforeView($helper->findSkziBySerialNumber(\Yii::$app->request->get('serialNumber')), \app\modules\lk\components\Fields::getFields('skzi'));
        return $list;
      }
    }
    
    public function actionUpdateDoc()
    {
      if($this->checkRights('update-doc') !== TRUE)
      {
        return;
      }
      if(\Yii::$app->request->isPost)
      {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = \Yii::$app->request->post('Docs');
        $model = \app\modules\lk\models\producer\Docs::findOne([
            'id' => (isset($data['id']) ? (int)$data['id'] : -1),
            'id_user' => \Yii::$app->user2->getId(),
                ]);
        if(!$model)
        {
          return ['error' => TRUE, 'html' => 'Документ не найден'];
        }
        $model->setScenario('update');
        $oldFile = $model->file;
        $model->load(\Yii::$app->request->post(), 'Docs');
        $newFile = \yii\web\UploadedFile::getInstance($model, 'file');
        if($newFile)
        {
          $model->file = $newFile;
          if(!$model->uploadFile())
          {
            return ['error' => TRUE, 'html' => 'Ошибка при загрузке файла'];
          }
        }
        else
        {
          $model->file = $oldFile;
        }
        
        if($model->save())
        {
          return ['error' => false, 'html' => 'Отредактировано'];
        }
        else
        {
          return ['error' => TRUE, 'html' => \yii\helpers\Html::errorSummary($model)];
        }
      }
    }
    
  public function actionHelp()
  {
    if($this->checkRights('help') !== TRUE)
    {
      return;
    }
    $sections = \app\modules\lk\models\HelpSections::getSecttionList(\app\modules\lk\models\HelpSections::MANUFACTURE_TYPE, 0);
    $pages = \app\modules\lk\models\HelpPages::getPageList(\app\modules\lk\models\HelpSections::MANUFACTURE_TYPE);
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
      $section = \app\modules\lk\models\HelpSections::findOne(['id' => $page->id_section, 'id_type' => \app\modules\lk\models\HelpSections::MANUFACTURE_TYPE]);
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
