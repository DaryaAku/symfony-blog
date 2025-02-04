<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findByTag($tag)
    {
        return $this->createQueryBuilder('p')
            ->join('p.tags', 't')
            ->where('t.name = :tag')
            ->setParameter('tag', $tag)
            ->getQuery()
            ->getResult();
    }

}
