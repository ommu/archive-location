<?php
/**
 * m200123_103810_archive_location_module_insert_menu
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2020 OMMU (www.ommu.id)
 * @created date 23 January 2020, 10:38 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;
use mdm\admin\components\Configs;
use app\models\Menu;

class m200123_103810_archive_location_module_insert_menu extends \yii\db\Migration
{
	public function up()
	{
        $menuTable = Configs::instance()->menuTable;
		$tableName = Yii::$app->db->tablePrefix . $menuTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'module', 'icon', 'parent', 'route', 'order', 'data'], [
				['Archive Location', 'archive-location', null, Menu::getParentId('SIKS#archive'), '/archive-location/admin/index', null, null],
			]);
		}
	}
}
