<?php
/**
 * archive-location module config
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 26 December 2019, 15:04 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

use ommu\archiveLocation\Events;
use ommu\archiveLocation\models\ArchiveLocationBuilding;

return [
	'id' => 'archive-location',
	'class' => ommu\archiveLocation\Module::className(),
	'events' => [
		[
			'class'    => ArchiveLocationBuilding::className(),
			'event'    => ArchiveLocationBuilding::EVENT_BEFORE_SAVE_ARCHIVE_LOCATION,
			'callback' => [Events::className(), 'onBeforeSaveArchiveLocation']
		],
	],
];