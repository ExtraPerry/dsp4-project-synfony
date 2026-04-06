<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[]
     */
    public function findBySearchCriteria(?string $query, ?string $authorName, ?int $categoryId): array
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->leftJoin('b.authors', 'a')
            ->leftJoin('b.categories', 'c')
            ->addSelect('a', 'c');

        if ($query) {
            $queryBuilder->andWhere('LOWER(b.title) LIKE :query')
                ->setParameter('query', '%' . strtolower($query) . '%');
        }

        if ($authorName) {
            $queryBuilder->andWhere('LOWER(a.firstName) LIKE :author OR LOWER(a.lastName) LIKE :author')
                ->setParameter('author', '%' . strtolower($authorName) . '%');
        }

        if ($categoryId) {
            $queryBuilder->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        return $queryBuilder
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
