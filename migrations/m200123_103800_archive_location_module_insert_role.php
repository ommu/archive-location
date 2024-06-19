<?php
/**
 * m200123_103800_archive_location_module_insert_role
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2020 OMMU (www.ommu.id)
 * @created date 23 January 2020, 10:38 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class m200123_103800_archive_location_module_insert_role extends \yii\db\Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

	public function up()
	{
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;

		$tableName = Yii::$app->db->tablePrefix . $authManager->itemTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'type', 'data', 'created_at'], [
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

		$tableName = Yii::$app->db->tablePrefix . $authManager->itemChildTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['parent', 'child'], [
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
