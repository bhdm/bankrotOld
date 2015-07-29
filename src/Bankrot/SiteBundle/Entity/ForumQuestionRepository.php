<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ForumQuestionRepository extends EntityRepository
{
    public function search($string){
        $result= $this
            ->createQueryBuilder('f')
            ->select('f')
            ->where("f.title LIKE '%$string%' ")
            ->orWhere("f.body LIKE '%$string%' ")
            ->getQuery()
            ->getResult();
        return $result;
    }

}