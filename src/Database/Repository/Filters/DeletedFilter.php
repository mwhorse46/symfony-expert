<?php
namespace App\Database\Repository\Filters;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

class DeletedFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->hasField("deletedAt")) {
            $date = date("Y-m-d h:m:s");

            return $targetTableAlias.".deletedAt < '".$date."' OR ".$targetTableAlias.".deletedAt IS NULL";
        }

        return "";
    }
}