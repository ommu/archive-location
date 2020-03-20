<?php
/**
 * ArchiveLocationStorage
 *
 * This is the ActiveQuery class for [[\ommu\archiveLocation\models\ArchiveLocationStorage]].
 * @see \ommu\archiveLocation\models\ArchiveLocationStorage
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 8 April 2019, 17:00 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation\models\query;

class ArchiveLocationStorage extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 */
	public function published() 
	{
		return $this->andWhere(['t.publish' => 1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function unpublish() 
	{
		return $this->andWhere(['t.publish' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deleted() 
	{
		return $this->andWhere(['t.publish' => 2]);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\ArchiveLocationStorage[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\ArchiveLocationStorage|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
