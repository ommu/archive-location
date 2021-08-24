<?php
/**
 * m210824_145723_archive_location_module_create_table_room
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 24 August 2021, 14:57 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;
use yii\db\Schema;

class m210824_145723_archive_location_module_create_table_room extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_archive_location_room';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL AUTO_INCREMENT',
				'room_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
				'storage_id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'PRIMARY KEY ([[id]])',
				'CONSTRAINT ommu_archive_location_room_ibfk_1 FOREIGN KEY ([[room_id]]) REFERENCES ommu_archive_location_building ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT ommu_archive_location_room_ibfk_2 FOREIGN KEY ([[storage_id]]) REFERENCES ommu_archive_location_storage ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
			], $tableOptions);

			$this->createIndex(
				'roomWithStorage',
				$tableName,
				['room_id', 'storage_id']
			);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_archive_location_room';
		$this->dropTable($tableName);
	}
}
