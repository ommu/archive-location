<?php
/**
 * ArchiveLocationRoom
 *
 * This is the ActiveQuery class for [[\ommu\archiveLocation\models\ArchiveLocationRoom]].
 * @see \ommu\archiveLocation\models\ArchiveLocationRoom
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 8 April 2019, 17:58 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation\models\query;

class ArchiveLocationRoom extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\ArchiveLocationRoom[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\ArchiveLocationRoom|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
