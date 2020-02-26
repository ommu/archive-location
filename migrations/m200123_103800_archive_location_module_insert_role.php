<?php
/**
 * m200123_103800_archive_location_module_insert_role
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2020 OMMU (www.ommu.co)
 * @created date 23 January 2020, 10:38 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;

class m200123_103800_archive_location_module_insert_role extends \yii\db\Migration
{
	public function up()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_auth_item';
		if(Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_auth_item', ['name', 'type', 'data', 'created_at'], [
				['archiveLocationModLevelAdmin', '2', '', time()],
				['archiveLocationModLevelModerator', '2', '', time()],
				['/archive-location/admin/*', '2', '', time()],
				['/archive-location/admin/index', '2', '', time()],
				['/archive-location/depo/*', '2', '', time()],
				['/archive-location/rack/*', '2', '', time()],
				['/archive-location/room/*', '2', '', time()],
				['/archive-location/storage/*', '2', '', time()],
			]);
		}

		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_auth_item_child';
		if(Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_auth_item_child', ['parent', 'child'], [
				['userAdmin', 'archiveLocationModLevelAdmin'],
				['userModerator', 'archiveLocationModLevelModerator'],
				['archiveLocationModLevelAdmin', 'archiveLocationModLevelModerator'],
				['archiveLocationModLevelModerator', '/archive-location/admin/*'],
				['archiveLocationModLevelModerator', '/archive-location/depo/*'],
				['archiveLocationModLevelModerator', '/archive-location/rack/*'],
				['archiveLocationModLevelModerator', '/archive-location/room/*'],
				['archiveLocationModLevelModerator', '/archive-location/storage/*'],
			]);
		}
	}
}
