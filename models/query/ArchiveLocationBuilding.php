<?php
/**
 * ArchiveLocationBuilding
 *
 * This is the ActiveQuery class for [[\ommu\archiveLocation\models\ArchiveLocationBuilding]].
 * @see \ommu\archiveLocation\models\ArchiveLocationBuilding
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 8 April 2019, 08:37 WIB
 * @link https://bitbucket.org/ommu/archive-location
 *
 */

namespace ommu\archiveLocation\models\query;

class ArchiveLocationBuilding extends \yii\db\ActiveQuery
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
	 * @return \ommu\archiveLocation\models\ArchiveLocationBuilding[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 */
	public function suggest() 
	{
		return $this->select(['id', 'location_name'])
			->published();
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\archiveLocation\models\ArchiveLocationBuilding|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
