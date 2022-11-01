<?php
/**
 * Archive Locations (archive-location)
 * @var $this app\components\View
 * @var $this ommu\archiveLocation\controllers\location\AdminController
 * @var $model ommu\archiveLocation\models\ArchiveLocationBuilding
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 8 April 2019, 08:42 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use yii\helpers\Url;

$context = $this->context;
if ($context->breadcrumbApp) {
    $this->params['breadcrumbs'][] = ['label' => $context->breadcrumbAppParam['name'], 'url' => [$context->breadcrumbAppParam['url']]];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['/archive-pengolahan/setting/admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Physical Storage'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => $model->getAttributeLabel('location_name'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->location_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Back to Detail'), 'url' => Url::to(['view', 'id' => $model->id]), 'icon' => 'eye', 'htmlOptions' => ['class' => 'btn btn-info']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id' => $model->id]), 'htmlOptions' => ['data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method' => 'post', 'class' => 'btn btn-danger'], 'icon' => 'trash'],
];
?>

<div class="archive-location-update">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>