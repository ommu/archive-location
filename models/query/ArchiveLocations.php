<?php
/**
 * ArchiveLocations
 *
 * This is the ActiveQuery class for [[\ommu\archiveLocation\models\ArchiveLocations]].
 * @see \ommu\archiveLocation\models\ArchiveLocations
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 31 May 2019, 21:23 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation\models\query;

class ArchiveLocations extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\ArchiveLocations[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\ArchiveLocations|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
