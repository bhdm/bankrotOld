<?php

namespace Bankrot\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LotRepository extends EntityRepository
{
    public function findActiveLots(User $owner, $search=null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('lw')
            ->from('BankrotSiteBundle:LotWatch', 'lw')
            ->leftJoin('BankrotSiteBundle:Lot', 'l', 'WITH', 'l = lw.lot')
            ->leftJoin('BankrotSiteBundle:LotStatus', 'ls', 'WITH', 'ls = l.lotStatus')
            ->leftJoin('BankrotSiteBundle:Category', 'c', 'WITH', 'c = l.category')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('lw.owner', ':owner'),
                $qb->expr()->isNotNull('l.initialPrice'),
                $qb->expr()->neq('ls.isTrash', 1)
            ))
            ->setParameter('owner', $owner);
        if (!empty($search)) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('c.name', ':search'),
                $qb->expr()->like('l.name', ':search')
            ))->setParameter('search', "%$search%");
        }

        return $qb->getQuery()->getResult();
    }

    public function findInactiveLots(User $owner)
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->innerJoin('BankrotSiteBundle:LotStatus', 'ls', 'WITH', 'ls = l.lotStatus')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('l.owner', ':owner'),
                $qb->expr()->isNull('l.initialPrice'),
                $qb->expr()->neq('ls.isTrash', 1)
            ))
            ->orderBy('l.createdAt', 'desc')
            ->setParameters([
                'owner' => $owner,
            ]);

        return $qb->getQuery()
            ->getResult();
    }

    public function findArchiveLots(User $owner)
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->innerJoin('BankrotSiteBundle:LotStatus', 'ls', 'WITH', 'ls = l.lotStatus')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('l.owner', ':owner'),
                $qb->expr()->eq('ls.isTrash', 1)
            ))
            ->orderBy('l.createdAt', 'desc')
            ->setParameters([
                'owner' => $owner,
            ]);

        return $qb->getQuery()
            ->getResult();
    }
}
