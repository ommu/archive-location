<?php
/**
 * DepoController
 * @var $this ommu\archiveLocation\controllers\DepoController
 * @var $model ommu\archiveLocation\models\ArchiveLocationBuilding
 *
 * DepoController implements the CRUD actions for ArchiveLocationBuilding model.
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
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 8 April 2019, 08:42 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation\controllers;

use Yii;
use ommu\archiveLocation\models\ArchiveLocationBuilding;

class DepoController extends AdminController
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
				'type' => 'depo',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return ArchiveLocationBuilding::TYPE_DEPO;
	}
}
