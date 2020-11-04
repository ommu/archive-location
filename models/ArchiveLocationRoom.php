<?php
/**
 * ArchiveLocationRoom
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 8 April 2019, 17:58 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 * This is the model class for table "ommu_archive_location_room".
 *
 * The followings are the available columns in table "ommu_archive_location_room":
 * @property integer $id
 * @property integer $room_id
 * @property integer $storage_id
 * @property string $creation_date
 * @property integer $creation_id
 *
 * The followings are the available model relations:
 * @property ArchiveLocation $room
 * @property ArchiveLocationStorage $storage
 * @property Users $creation
 *
 */

namespace ommu\archiveLocation\models;

use Yii;
use app\models\Users;

class ArchiveLocationRoom extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	public $roomLocationName;
	public $storageName;
	public $creationDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_archive_location_room';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['room_id', 'storage_id'], 'required'],
			[['room_id', 'storage_id', 'creation_id'], 'integer'],
			[['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchiveLocationBuilding::className(), 'targetAttribute' => ['room_id' => 'id']],
			[['storage_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchiveLocationStorage::className(), 'targetAttribute' => ['storage_id' => 'id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'room_id' => Yii::t('app', 'Room'),
			'storage_id' => Yii::t('app', 'Storage'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'roomLocationName' => Yii::t('app', 'Room'),
			'storageName' => Yii::t('app', 'Storage'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRoom()
	{
		return $this->hasOne(ArchiveLocationBuilding::className(), ['id' => 'room_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getStorage()
	{
		return $this->hasOne(ArchiveLocationStorage::className(), ['id' => 'storage_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\query\ArchiveLocationRoom the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\archiveLocation\models\query\ArchiveLocationRoom(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
        parent::init();

        if (!(Yii::$app instanceof \app\components\Application)) {
            return;
        }

        if (!$this->hasMethod('search')) {
            return;
        }

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['roomLocationName'] = [
			'attribute' => 'roomLocationName',
			'value' => function($model, $key, $index, $column) {
				return isset($model->room) ? $model->room->location_name : '-';
				// return $model->roomLocationName;
			},
			'visible' => !Yii::$app->request->get('room') ? true : false,
		];
		$this->templateColumns['storage_id'] = [
			'attribute' => 'storage_id',
			'value' => function($model, $key, $index, $column) {
				return isset($model->storage) ? $model->storage->title->message : '-';
				// return $model->storageName;
			},
			'filter' => ArchiveLocationStorage::getStorage(),
			'visible' => !Yii::$app->request->get('storage') ? true : false,
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		$this->templateColumns['creationDisplayname'] = [
			'attribute' => 'creationDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->creation) ? $model->creation->displayname : '-';
				// return $model->creationDisplayname;
			},
			'visible' => !Yii::$app->request->get('creation') ? true : false,
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
        if ($column != null) {
            $model = self::find();
            if (is_array($column)) {
                $model->select($column);
            } else {
                $model->select([$column]);
            }
            $model = $model->where(['id' => $id])->one();
            return is_array($column) ? $model : $model->$column;

        } else {
            $model = self::findOne($id);
            return $model;
        }
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->roomLocationName = isset($this->room) ? $this->room->location_name : '-';
		// $this->storageName = isset($this->storage) ? $this->storage->title->message : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                if ($this->creation_id == null) {
                    $this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                }
            }
        }
        return true;
	}
}
