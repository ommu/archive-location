<?php
/**
 * m210824_145656_archive_location_module_create_table_storage
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

class m210824_145656_archive_location_module_create_table_storage extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_archive_location_storage';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED NOT NULL AUTO_INCREMENT',
				'publish' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'1\'',
				'parent_id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED',
				'storage_name' => Schema::TYPE_INTEGER . '(11) NOT NULL COMMENT \'trigger[delete]\'',
				'storage_desc' => Schema::TYPE_INTEGER . '(11) NOT NULL COMMENT \'trigger[delete],text\'',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'updated_date' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'trigger\'',
				'PRIMARY KEY ([[id]])',
			], $tableOptions);

			$this->createIndex(
				'publishWithParentAndStorageName',
				$tableName,
				['publish', 'parent_id', 'storage_name']
			);

			$this->createIndex(
				'publishWithStorageName',
				$tableName,
				['publish', 'storage_name']
			);

			$this->createIndex(
				'storage_name',
				$tableName,
				['storage_name']
			);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_archive_location_storage';
		$this->dropTable($tableName);
	}
}
