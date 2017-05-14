<?php
namespace yii\easyii\modules\masters\api;

use Yii;
use yii\easyii\components\API;
use yii\easyii\models\Photo;
use yii\easyii\modules\masters\models\Masters as MastersModel;
use yii\helpers\Url;

class MastersObject extends \yii\easyii\components\ApiObject
{
    public $slug;
    public $photo;
    public $rating;

    private $_photos;

    public function getName(){
        return LIVE_EDIT ? API::liveEdit($this->model->name, $this->editLink) : $this->model->name;
    }

    public function getPhotos()
    {
        if(!$this->_photos){
            $this->_photos = [];

            foreach(Photo::find()->where(['class' => MastersModel::className(), 'item_id' => $this->id])->sort()->all() as $model){
                $this->_photos[] = new PhotoObject($model);
            }
        }
        return $this->_photos;
    }

    public function  getEditLink(){
        return Url::to(['/admin/masters/a/edit/', 'id' => $this->id]);
    }
}