<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findByUserAndBook(User $user, Book $book): ?Review
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.reviewer = :user')
            ->andWhere('r.book = :book')
            ->setParameter('user', $user)
            ->setParameter('book', $book)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Review[]
     */
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.reviewer', 'u')
            ->leftJoin('r.book', 'b')
            ->addSelect('u', 'b')
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
