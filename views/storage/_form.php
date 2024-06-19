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

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\archiveLocation\models\ArchiveLocationStorage;
?>

<div class="archive-storage-form">

<?php $form = ActiveForm::begin([
	'options' => ['class' => 'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php $parentId = ArchiveLocationStorage::getStorage();
echo $form->field($model, 'parent_id')
	->dropDownList($parentId, ['prompt' => ''])
	->label($model->getAttributeLabel('parent_id')); ?>

<?php echo $form->field($model, 'storage_name_i')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('storage_name_i')); ?>

<?php echo $form->field($model, 'storage_desc_i')
	->textarea(['rows' => 4, 'cols' => 50, 'maxlength' => true])
	->label($model->getAttributeLabel('storage_desc_i')); ?>

<?php 
if ($model->isNewRecord && !$model->getErrors()) {
    $model->publish = 1;
}
echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>