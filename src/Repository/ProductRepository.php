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
    public function search(?string $txt)
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

        return $qb->orderBy('p.name', 'ASC');
    }
}
