<?php
/**
 * m200123_103800_archive_location_module_insert_menu
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2020 OMMU (www.ommu.co)
 * @created date 23 January 2020, 10:38 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;

class m200123_103800_archive_location_module_insert_menu extends \yii\db\Migration
{
	public function up()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_menus';
		if(Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_menus', ['name', 'module', 'icon', 'parent', 'route', 'order', 'data'], [
				['Archive Location', 'archive-location', null, null, '/archive-location/admin/index', null, null],
			]);
		}
	}
}
