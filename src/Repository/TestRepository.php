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
    }

    public function findByTag(Tag $tag)
    {
        return $this->_em->createQuery('
            SELECT test FROM ' . Test::class . ' test
            INNER JOIN test.tags tag
            WHERE tag = :tag
        ')
            ->setParameters([
                'tag' => $tag
            ])
            ->getResult();
    }

    public function searchByKeyword($searchString)
    {
        return $this->_em->createQuery('
            SELECT test FROM ' . Test::class . ' test
            INNER JOIN test.tags tag
            WHERE tag.name LIKE :tagName
            OR test.name LIKE :testName
        ')
            ->setParameters([
                'tagName' => "%$searchString%",
                'testName' => "%$searchString%"
            ])
            ->getResult();
    }

    public function createFindAllQuery()
    {
        return $this->_em->createQuery('SELECT t FROM ' . Test::class . ' t');
    }
}
