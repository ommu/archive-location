<?php
/**
 * m210824_145759_archive_location_module_create_table_locations
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 24 August 2021, 14:58 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;
use yii\db\Schema;

class m210824_145759_archive_location_module_create_table_locations extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_archive_locations';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL AUTO_INCREMENT',
				'archive_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
				'room_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'rack_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'storage_id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED',
				'location_desc' => Schema::TYPE_TEXT . ' NOT NULL',
				'weight' => Schema::TYPE_STRING . '(6) NOT NULL',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'PRIMARY KEY ([[id]])',
				'CONSTRAINT ommu_archive_locations_ibfk_1 FOREIGN KEY ([[room_id]]) REFERENCES ommu_archive_location_building ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT ommu_archive_locations_ibfk_2 FOREIGN KEY ([[archive_id]]) REFERENCES ommu_archives ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT ommu_archive_locations_ibfk_3 FOREIGN KEY ([[storage_id]]) REFERENCES ommu_archive_location_storage ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
			], $tableOptions);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_archive_locations';
		$this->dropTable($tableName);
	}
}
