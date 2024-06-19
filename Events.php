<?php
/**
 * Events class
 *
 * Menangani event-event yang ada pada modul archive-location.
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 26 December 2019, 15:58 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation;

use Yii;
use ommu\archiveLocation\models\ArchiveLocationRoom;

class Events extends \yii\base\BaseObject
{
	/**
	 * {@inheritdoc}
	 */
	public static function onBeforeSaveArchiveLocation($event)
	{
		$location = $event->sender;

		$oldStorage = array_flip($location->getRoomStorage(true));
		$storage = $location->storage;

		// insert difference storage
        if (is_array($storage)) {
			foreach ($storage as $val) {
                if (in_array($val, $oldStorage)) {
					unset($oldStorage[array_keys($oldStorage, $val)[0]]);
					continue;
				}

				$model = new ArchiveLocationRoom();
				$model->room_id = $location->id;
				$model->storage_id = $val;
				$model->save();
			}
		}

		// drop difference storage
        if (!empty($oldStorage)) {
			foreach ($oldStorage as $key => $val) {
				ArchiveLocationRoom::find()
					->select(['id'])
					->andWhere(['id' => $key])
					->one()
					->delete();
			}
		}
		
	}
}
