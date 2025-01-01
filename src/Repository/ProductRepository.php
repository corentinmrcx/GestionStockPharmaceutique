<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function search(?string $txt, array $filters = [])
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.category', 'cat')
            ->leftJoin('p.brand', 'brand')
            ->addSelect('cat', 'brand');

        if (!empty($txt)) {
            $qb->where('p.name LIKE :txt')
                ->orWhere('cat.nameCategory LIKE :txt')
                ->orWhere('brand.name LIKE :txt')
                ->setParameter('txt', "%$txt%");
        }

        if (!empty($filters['category'])) {
            $qb->andWhere('cat.id = :category')
                ->setParameter('category', $filters['category']);
        }

        if (!empty($filters['brand'])) {
            $qb->andWhere('brand.id = :brand')
                ->setParameter('brand', $filters['brand']);
        }

        if (!empty($filters['priceMin']) && is_numeric($filters['priceMin'])) {
            $qb->andWhere('p.price >= :priceMin')
                ->setParameter('priceMin', $filters['priceMin']);
        }

        if (!empty($filters['priceMax']) && is_numeric($filters['priceMax'])) {
            $qb->andWhere('p.price <= :priceMax')
                ->setParameter('priceMax', $filters['priceMax']);
        }

        return $qb->orderBy('p.name', 'ASC');
    }



}
