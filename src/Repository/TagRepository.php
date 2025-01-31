<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    // Метод для получения всех постов категории
    public function getPostsFotTag($tagId)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.posts', 'p')
            ->andWhere('c.id = :categoryId')
            ->setParameter('categoryId', $tagId)
            ->getQuery()
            ->getResult();
    }
}
