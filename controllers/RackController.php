<?php
/**
 * RackController
 * @var $this ommu\archiveLocation\controllers\RackController
 * @var $model ommu\archiveLocation\models\ArchiveLocationBuilding
 *
 * RackController implements the CRUD actions for ArchiveLocationBuilding model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Create
 *	Update
 *	View
 *	Delete
 *	RunAction
 *	Publish
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 8 April 2019, 08:42 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation\controllers;

use Yii;
use ommu\archiveLocation\models\ArchiveLocationBuilding;
use ommu\archiveLocation\models\ArchiveLocationStorage;

class RackController extends AdminController
{
	/**
	 * {@inheritdoc}
	 */
	public function allowAction(): array {
		return ['suggest'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'suggest' => [
				'class' => 'ommu\archiveLocation\actions\LocationSuggestAction',
				'type' => 'rack',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return ArchiveLocationBuilding::TYPE_RACK;
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionStorage() 
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$id = Yii::$app->request->get('id');

		if($id == null) return [];

		$model = ArchiveLocationBuilding::findOne($id);

		$result = [];
		if(!empty($storage = $model->getRoomStorage(true, 'title'))) {
			foreach($storage as $key => $val) {
				$result[] = [
					'id' => $key,
					'label' => $val,
				];
			}
		}
		return $result;
	}
}
