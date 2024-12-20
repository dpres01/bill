<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Occupant>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findOccupants(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.firstName, p.lastName, p.birthday, p.occupant, p.fromDate')
            ->where('p.occupant = 1')
            ->orderBy('p.id','desc')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPersonByStatus(bool $occupant): array
    {
        return $this->createQueryBuilder('p')
            ->select("p.id, concat(concat(p.firstName,' '), p.lastName) name")
            ->where('p.occupant=:occ')
            ->setParameter('occ',$occupant)
            ->getQuery()
            ->getResult();
    }
}
