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
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Physical Storage'), 'url' => ['admin/index']];
if (isset($model->parent)) {
	$controller = $model->parent->type;
    if ($controller == 'building') {
        $controller = 'admin';
    }
	$this->params['breadcrumbs'][] = ['label' => $model->getAttributeLabel('parent_id').': '.$model->parent->location_name, 'url' => ['location/'.$controller.'/view', 'id' => $model->parent_id]];
}
$this->params['breadcrumbs'][] = ['label' => $model->getAttributeLabel('location_name'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="archive-location-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
