<?php

namespace App\Repository;

use App\Entity\Program;
use App\Entity\Actor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    public function save(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLikeName(string $name)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.title LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.title', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    public function findLikeNameOrByActor($name)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.title LIKE :name')
            ->join('p.actors', 'a')
            ->orWhere('a.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')

            ->getQuery();
        return $queryBuilder->getResult();
    }
}
