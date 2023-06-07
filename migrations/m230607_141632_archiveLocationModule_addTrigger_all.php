<?php
/**
 * m230607_141632_archiveLocationModule_addTrigger_all
 *
 * @author Putra Sudaryanto <dwptr@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2023 OMMU (www.ommu.id)
 * @created date 7 June 2023, 14:17 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use Yii;
use yii\db\Schema;

class m230607_141632_archiveLocationModule_addTrigger_all extends \yii\db\Migration
{
	public function up()
	{
		// alter trigger archiveBeforeUpdateLocationBuilding
		$alterTriggerArchiveBeforeUpdateLocationBuilding = <<< SQL
CREATE
    TRIGGER `archiveBeforeUpdateLocationBuilding` BEFORE UPDATE ON `ommu_archive_location_building` 
    FOR EACH ROW BEGIN
	IF (NEW.publish <> OLD.publish) THEN
		SET NEW.updated_date = NOW();
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `archiveBeforeUpdateLocationBuilding`');
		$this->execute($alterTriggerArchiveBeforeUpdateLocationBuilding);

		// alter trigger archiveBeforeUpdateLocationStorage
		$alterTriggerArchiveBeforeUpdateLocationStorage = <<< SQL
CREATE
    TRIGGER `archiveBeforeUpdateLocationStorage` BEFORE UPDATE ON `ommu_archive_location_storage` 
    FOR EACH ROW BEGIN
	IF (NEW.publish <> OLD.publish) THEN
		SET NEW.updated_date = NOW();
	END IF;
    END;
SQL;
        $this->execute('DROP TRIGGER IF EXISTS `archiveBeforeUpdateLocationStorage`');
		$this->execute($alterTriggerArchiveBeforeUpdateLocationStorage);
	}

	public function down()
	{
        $this->execute('DROP TRIGGER IF EXISTS `archiveBeforeUpdateLocationBuilding`');
        $this->execute('DROP TRIGGER IF EXISTS `archiveBeforeUpdateLocationStorage`');
	}
}
