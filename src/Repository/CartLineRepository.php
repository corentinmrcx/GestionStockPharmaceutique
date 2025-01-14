<?php

namespace App\Repository;

use App\Entity\CartLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartLine>
 */
class CartLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartLine::class);
    }

    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('cl')
            ->innerJoin('cl.cart', 'c')
            ->innerJoin('c.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function countItemsByUser(int $userId): int
    {
        return $this->createQueryBuilder('clc')
            ->select('SUM(clc.quantity)')
            ->join('clc.cart', 'c')
            ->where('c.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }
}
