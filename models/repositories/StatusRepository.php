<?php
namespace app\models\repositories;

use app\models\entities\Status;
use app\models\Repository;

class StatusRepository extends Repository
{
  public function getEntityClass()
  {
    return Status::class;
  }

  public function getTableName()
  {
    return "status";
  }
}