<?php
/**
 * archive-location module definition class
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 26 December 2019, 15:04 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation;

use Yii;

class Module extends \app\components\Module
{
	public $layout = 'main';

	/**
	 * {@inheritdoc}
	 */
	public $controllerNamespace = 'ommu\archiveLocation\controllers';

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
        parent::init();
	}
}
