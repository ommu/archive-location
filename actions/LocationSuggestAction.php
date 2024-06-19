<?php
/**
 * LocationSuggestAction
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 31 May 2019, 17:20 WIB
 * @link https://bitbucket.org/ommu/archive-location
 */

namespace ommu\archiveLocation\actions;

use Yii;
use ommu\archiveLocation\models\ArchiveLocationBuilding;

class LocationSuggestAction extends \yii\base\Action
{
	public $type;

	/**
	 * {@inheritdoc}
	 */
	protected function beforeRun()
	{
        if (parent::beforeRun()) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			Yii::$app->response->charset = 'UTF-8';
        }
        return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function run()
	{
		$parent = Yii::$app->request->get('parent');

        if ($parent == null) return [];

		$model = ArchiveLocationBuilding::find()
            ->alias('t')
			->suggest()
			->andWhere(['t.parent_id' => $parent])
			->andWhere(['t.type' => $this->type])
			->all();

		$result = [];
        foreach ($model as $val) {
			$result[] = [
				'id' => $val->id, 
				'label' => $val->location_name,
			];
		}
		return $result;
	}
}
