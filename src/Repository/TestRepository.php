<?php

namespace App\Repository;

use App\Entity\Tag;
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
        //todo per Month
        return $this->_em->createQuery('
            SELECT t FROM ' . Test::class . ' t
            ORDER BY t.successAttempts+t.failedAttempts DESC
        ')
        ->setMaxResults(5)
        ->execute();

        //todo delete it, or replace
        return $this->createQueryBuilder('test')
            ->orderBy('test.successAttempts+test.failedAttempts', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findByTag(Tag $tag){
        return $this->createQueryBuilder('test')
            ->innerJoin('test.tags', 'tag')
            ->andWhere('tag = :tag')
            ->setParameter('tag', $tag)
            ->getQuery()
            ->execute();
    }

    public function findByNameOrTagInclusions($searchString)
    {
        return $this->createQueryBuilder('test')
            ->innerJoin('test.tags', 'tag')
            ->andWhere('tag.name LIKE :name')
            ->setParameter('name', "%$searchString%")
            ->orWhere('test.name LIKE :name')
            ->setParameter('name', "%$searchString%")
            ->getQuery()
            ->execute();
    }
}
