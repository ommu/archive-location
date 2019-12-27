<?php
/**
 * Archive Storages (archive-storage)
 * @var $this app\components\View
 * @var $this ommu\archiveLocation\controllers\StorageController
 * @var $model ommu\archiveLocation\models\ArchiveLocationStorage
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 8 April 2019, 17:04 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SIKS'), 'url' => ['/archive/fond/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Storage Location'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Storage'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="archive-storage-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
