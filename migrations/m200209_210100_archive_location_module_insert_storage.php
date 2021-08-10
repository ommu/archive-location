<?php
/**
 * m200209_210100_archive_location_module_insert_storage
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2020 OMMU (www.ommu.id)
 * @created date 9 February 2020, 21:02 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;
use app\models\SourceMessage;

class m200209_210100_archive_location_module_insert_storage extends \yii\db\Migration
{
	public function up()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_archive_location_storage';
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_archive_location_storage', ['parent_id', 'storage_name', 'storage_desc'], [
				[null, SourceMessage::setMessage('Box', 'archive storage title'), null],
				[null, SourceMessage::setMessage('Cardboard Box', 'archive storage title'), null],
				[null, SourceMessage::setMessage('Hollinger Box', 'archive storage title'), null],
				[null, SourceMessage::setMessage('Folder', 'archive storage title'), null],
				[null, SourceMessage::setMessage('Filing Cabinet', 'archive storage title'), null],
				[null, SourceMessage::setMessage('Map Cabinet', 'archive storage title'), null],
				[null, SourceMessage::setMessage('Shelf', 'archive storage title'), null],
			]);
		}
	}
}
