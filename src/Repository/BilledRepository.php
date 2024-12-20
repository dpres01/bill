<?php

namespace App\Repository;

use App\Entity\Billed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Billed>
 */
class BilledRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billed::class);
    }

   public function findBills(): array
   {
        return $this->createQueryBuilder('b')
            ->select("b.id, concat(concat(o.firstName,' '), o.lastName) owner, concat(concat(r.firstName,' '), r.lastName) renter, b.amount, b.chargesAmount, b.total")
            ->join('b.owner','o')
            ->join('b.renter','r')
            ->orderBy('b.id','desc')
            ->getQuery()
            ->getResult()
        ;
    }
}
