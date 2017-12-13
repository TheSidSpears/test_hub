<?php

namespace App\Repository;

use App\Entity\Test;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Test::class);
    }


    public function findFivePopularPerMonth()
    {
        return $this->createQueryBuilder('test')
            //todo per Month
            ->orderBy('test.successAttempts+test.failedAttempts', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findByNameOrTag($searchString)
    {
        return $this->createQueryBuilder('test')
            ->innerJoin('test.tags','tag')
            ->andWhere('tag.name LIKE :name')
            ->setParameter('name', "%$searchString%")
            ->orWhere('test.name LIKE :name')
            ->setParameter('name', "%$searchString%")
            ->getQuery()
            ->execute();
    }
}
