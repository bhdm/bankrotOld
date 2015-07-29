<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    public function search($string){
        $result= $this
            ->createQueryBuilder('p')
            ->select('p')
            ->where("p.title LIKE '%$string%' ")
            ->orWhere("p.body LIKE '%$string%' ")
            ->getQuery()
            ->getResult();
        return $result;
    }

}
