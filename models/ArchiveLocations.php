<?php
/**
 * ArchiveLocations
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 31 May 2019, 21:23 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 * This is the model class for table "ommu_archive_locations".
 *
 * The followings are the available columns in table "ommu_archive_locations":
 * @property integer $id
 * @property integer $archive_id
 * @property integer $room_id
 * @property integer $rack_id
 * @property integer $storage_id
 * @property string $location_desc
 * @property string $weight
 * @property string $creation_date
 * @property integer $creation_id
 *
 * The followings are the available model relations:
 * @property ArchiveLocationBuilding $room
 * @property ArchiveLocationBuilding $depo
 * @property ArchiveLocationBuilding $building
 * @property Archives $archive
 * @property ArchiveLocationBuilding $storage
 * @property Users $creation
 *
 */

namespace ommu\archiveLocation\models;

use Yii;
use ommu\archive\models\Archives;
use ommu\users\models\Users;

class ArchiveLocations extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = [];

	public $archiveTitle;
	public $roomLocationName;
	public $rackLocationName;
	public $creationDisplayname;

	public $building_id;
	public $depo_id;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_archive_locations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['archive_id', 'room_id', 'rack_id', 'storage_id', 'building_id', 'depo_id'], 'required'],
			[['archive_id', 'room_id', 'rack_id', 'storage_id', 'creation_id'], 'integer'],
			[['location_desc', 'weight'], 'string'],
			[['location_desc', 'weight'], 'safe'],
			[['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchiveLocationBuilding::className(), 'targetAttribute' => ['room_id' => 'id']],
			[['rack_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchiveLocationBuilding::className(), 'targetAttribute' => ['rack_id' => 'id']],
			[['storage_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchiveLocationStorage::className(), 'targetAttribute' => ['storage_id' => 'id']],
			[['archive_id'], 'exist', 'skipOnError' => true, 'targetClass' => Archives::className(), 'targetAttribute' => ['archive_id' => 'id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'archive_id' => Yii::t('app', 'Archive'),
			'room_id' => Yii::t('app', 'Room'),
			'rack_id' => Yii::t('app', 'Rack'),
			'storage_id' => Yii::t('app', 'Storage'),
			'location_desc' => Yii::t('app', 'Noted'),
			'weight' => Yii::t('app', 'Weight'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'archiveTitle' => Yii::t('app', 'Archive'),
			'roomLocationName' => Yii::t('app', 'Room'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'building_id' => Yii::t('app', 'Building'),
			'depo_id' => Yii::t('app', 'Depo'),
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
	public function getRack()
	{
		return $this->hasOne(ArchiveLocationBuilding::className(), ['id' => 'rack_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDepo()
	{
		return $this->hasOne(ArchiveLocationBuilding::className(), ['id' => 'parent_id'])
			->via('room');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBuilding()
	{
		return $this->hasOne(ArchiveLocationBuilding::className(), ['id' => 'parent_id'])
			->via('depo');
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
	public function getArchive()
	{
		return $this->hasOne(Archives::className(), ['id' => 'archive_id']);
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
	 * @return \ommu\archiveLocation\models\query\ArchiveLocations the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\archiveLocation\models\query\ArchiveLocations(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		if(!$this->hasMethod('search'))
			return;

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['archiveTitle'] = [
			'attribute' => 'archiveTitle',
			'value' => function($model, $key, $index, $column) {
				return isset($model->archive) ? $model->archive->title : '-';
				// return $model->archiveTitle;
			},
			'visible' => !Yii::$app->request->get('archive') ? true : false,
		];
		$this->templateColumns['roomLocationName'] = [
			'attribute' => 'roomLocationName',
			'value' => function($model, $key, $index, $column) {
				return isset($model->room) ? $model->room->location_name : '-';
				// return $model->roomLocationName;
			},
			'creator' => !Yii::$app->request->get('room') ? true : false,
		];
		$this->templateColumns['rackLocationName'] = [
			'attribute' => 'rackLocationName',
			'value' => function($model, $key, $index, $column) {
				return isset($model->rack) ? $model->rack->location_name : '-';
				// return $model->rackLocationName;
			},
			'creator' => !Yii::$app->request->get('rack') ? true : false,
		];
		$this->templateColumns['location_desc'] = [
			'attribute' => 'location_desc',
			'value' => function($model, $key, $index, $column) {
				return $model->location_desc;
			},
		];
		$this->templateColumns['storage_id'] = [
			'attribute' => 'storage_id',
			'value' => function($model, $key, $index, $column) {
				return isset($model->storage) ? $model->storage->storage_name_i : '-';
			},
			'creator' => !Yii::$app->request->get('storage') ? true : false,
		];
		$this->templateColumns['weight'] = [
			'attribute' => 'weight',
			'value' => function($model, $key, $index, $column) {
				return $model->weight;
			},
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
		if($column != null) {
			$model = self::find();
			if(is_array($column))
				$model->select($column);
			else
				$model->select([$column]);
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

		// $this->archiveTitle = isset($this->archive) ? $this->archive->title : '-';
		// $this->roomLocationName = isset($this->room) ? $this->room->location_name : '-';
		// $this->rackLocationName = isset($this->rack) ? $this->rack->location_name : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		$this->building_id = isset($this->depo) ? $this->depo->parent_id : null;
		$this->depo_id = isset($this->room) ? $this->room->parent_id : null;
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->creation_id == null)
					$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			}
		}
		return true;
	}
}
