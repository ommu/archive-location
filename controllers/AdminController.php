<?php
/**
 * AdminController
 * @var $this ommu\archiveLocation\controllers\AdminController
 * @var $model ommu\archiveLocation\models\ArchiveLocationBuilding
 *
 * AdminController implements the CRUD actions for ArchiveLocationBuilding model.
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
use app\components\Controller;
use mdm\admin\components\AccessControl;
use yii\filters\VerbFilter;
use ommu\archiveLocation\models\ArchiveLocationBuilding;
use ommu\archiveLocation\models\search\ArchiveLocationBuilding as ArchiveLocationBuildingSearch;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use ommu\archive\models\ArchiveSetting;

class AdminController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
        parent::init();

        $this->subMenu = $this->module->params['location_submenu'];

		$setting = ArchiveSetting::find()
			->select(['breadcrumb_param'])
			->where(['id' => 1])
			->one();
		$this->breadcrumbApp = $setting->breadcrumb;
		$this->breadcrumbAppParam = $setting->getBreadcrumbAppParam();
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'publish' => ['POST'],
                ],
            ],
        ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
        return $this->redirect(['manage']);
	}

	/**
	 * Lists all ArchiveLocationBuilding models.
	 * @return mixed
	 */
	public function actionManage()
	{
        $searchModel = new ArchiveLocationBuildingSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $gridColumn = Yii::$app->request->get('GridColumn', null);
        $cols = [];
        if ($gridColumn != null && count($gridColumn) > 0) {
            foreach ($gridColumn as $key => $val) {
                if ($gridColumn[$key] == 1) {
                    $cols[] = $key;
                }
            }
        }
        $columns = $searchModel->getGridColumn($cols);

        if (($parent = Yii::$app->request->get('parent')) != null) {
            $parent = ArchiveLocationBuilding::findOne($parent);
            if ($parent->type == 'building') {
				$attributes = ['location_name' => $parent::getType($parent::TYPE_BUILDING), 'id' => $parent::getType($parent::TYPE_DEPO)];
            } else if ($parent->type == 'depo') {
				$attributes = ['location_name' => $parent::getType($parent::TYPE_DEPO), 'id' => $parent::getType($parent::TYPE_ROOM)];
            } else if ($parent->type == 'room') {
				$attributes = ['location_name' => $parent::getType($parent::TYPE_ROOM), 'id' => $parent::getType($parent::TYPE_RACK)];
            }
			$parent->setAttributeLabels($attributes);
		}

		$this->view->title = Yii::t('app', Inflector::pluralize($this->title));
        if ($parent) {
			$this->view->title = Yii::t('app', '{location} in {parent}: {parent-name}', [
                'location' => Inflector::pluralize($this->title), 
                'parent' => $parent->getAttributeLabel('location_name'), 
                'parent-name' => $parent->location_name,
            ]);
        }
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'parent' => $parent ?? null,
		]);
	}

	/**
	 * Creates a new ArchiveLocationBuilding model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
        $model = new ArchiveLocationBuilding();
		$attributes = ['location_name' => $this->title];
        if ($this->type == 'depo') {
			$attributes = ArrayHelper::merge($attributes, ['parent_id' => ArchiveLocationBuilding::getType(ArchiveLocationBuilding::TYPE_BUILDING)]);
        } else if ($this->type == 'room') {
			$attributes = ArrayHelper::merge($attributes, ['parent_id' => ArchiveLocationBuilding::getType(ArchiveLocationBuilding::TYPE_DEPO)]);
        } else if ($this->type == 'rack') {
			$attributes = ['location_name' => Yii::t('app', '{rack} Number', ['rack' => $this->title])];
			$attributes = ArrayHelper::merge($attributes, [
				'parent_id' => ArchiveLocationBuilding::getType(ArchiveLocationBuilding::TYPE_ROOM),
				'building' => ArchiveLocationBuilding::getType(ArchiveLocationBuilding::TYPE_DEPO),
			]);
		}
		$model->setAttributeLabels($attributes);

        if ($this->type != 'building') {
			$model->scenario = ArchiveLocationBuilding::SCENARIO_NOT_BUILDING;
            if ($this->type == 'room') {
				$model->scenario = ArchiveLocationBuilding::SCENARIO_ROOM;
            } else if ($this->type == 'rack') {
				$model->scenario = ArchiveLocationBuilding::SCENARIO_RACK;
            }
		}

        $building = null;
        if (($id = Yii::$app->request->get('id')) != null) {
            $model->parent_id = $id;
            $building = $model->parent->parent_id;
        }
		$model->building = $building;
		$model->type = $this->type;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Physical storage {title} success created.', [
                    'title' => strtolower($this->title),
                ]));
                if (!Yii::$app->request->isAjax) {
                    return $this->redirect(['manage']);
                }
                return $this->redirect(Yii::$app->request->referrer ?: ['manage']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Create {title}', [
            'title' => $this->title,
        ]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing ArchiveLocationBuilding model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
        if ($this->type != 'building') {
			$model->scenario = ArchiveLocationBuilding::SCENARIO_NOT_BUILDING;
            if ($this->type == 'room') {
				$model->scenario = ArchiveLocationBuilding::SCENARIO_ROOM;
            } else if ($this->type == 'rack') {
				$model->scenario = ArchiveLocationBuilding::SCENARIO_RACK;
            }
		}

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Physical storage {title} success updated.', [
                    'title' => strtolower($this->title),
                ]));
                if (!Yii::$app->request->isAjax) {
                    return $this->redirect(['manage']);
                }
                return $this->redirect(Yii::$app->request->referrer ?: ['manage']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Update {title}: {location-name}', [
            'title' => $this->title, 
            'location-name' => $model->location_name,
        ]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single ArchiveLocationBuilding model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
        $model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail {title}: {location-name}', [
            'title' => $this->title, 
            'location-name' => $model->location_name,
        ]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
			'small' => false,
		]);
	}

	/**
	 * Deletes an existing ArchiveLocationBuilding model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

        if ($model->save(false, ['publish', 'modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Physical storage {title} success deleted.', [
                'title' => strtolower($this->title),
            ]));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage']);
		}
	}

	/**
	 * actionPublish an existing ArchiveLocationBuilding model.
	 * If publish is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionPublish($id)
	{
		$model = $this->findModel($id);
		$replace = $model->publish == 1 ? 0 : 1;
		$model->publish = $replace;

        if ($model->save(false, ['publish', 'modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Physical storage {title} success updated.', [
                'title' => strtolower($this->title),
            ]));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage']);
		}
	}

	/**
	 * Finds the ArchiveLocationBuilding model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ArchiveLocationBuilding the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
        if (($model = ArchiveLocationBuilding::findOne($id)) !== null) {
			$attributes = ['location_name' => $this->title];
            if ($model->type == 'depo') {
				$attributes = ArrayHelper::merge($attributes, ['parent_id' => ArchiveLocationBuilding::getType(ArchiveLocationBuilding::TYPE_BUILDING)]);
            }
            if ($model->type == 'room') {
				$attributes = ArrayHelper::merge($attributes, ['parent_id' => ArchiveLocationBuilding::getType(ArchiveLocationBuilding::TYPE_DEPO)]);
            }
			$model->setAttributeLabels($attributes);

			return $model;
		}

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getViewPath()
	{
		return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'admin';
	}

	/**
	 * Type of Location.
	 * @return string
	 */
	public function getType()
	{
		return ArchiveLocationBuilding::TYPE_BUILDING;
	}

	/**
	 * Title of Location.
	 * @return string
	 */
	public function getTitle()
	{
		return ArchiveLocationBuilding::getType($this->type);
	}
}
