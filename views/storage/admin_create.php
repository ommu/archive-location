<?php
/**
 * Archive Storages (archive-storage)
 * @var $this app\components\View
 * @var $this ommu\archiveLocation\controllers\StorageController
 * @var $model ommu\archiveLocation\models\ArchiveLocationStorage
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 8 April 2019, 17:04 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use yii\helpers\Url;

$context = $this->context;
if ($context->breadcrumbApp) {
    $this->params['breadcrumbs'][] = ['label' => $context->breadcrumbAppParam['name'], 'url' => [$context->breadcrumbAppParam['url']]];
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['/archive/setting/admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Physical Storage'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Storage'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="archive-storage-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
