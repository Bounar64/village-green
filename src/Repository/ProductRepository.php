<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @return Product[]
     */
    public function findSearch(SearchData $search): array
    {
       $query = $this
        ->createQueryBuilder('p');

        if(!empty($search->getKw())) {
            $query = $query
                ->andWhere('p.brand LIKE :kw')
                ->setParameter('kw', "%{$search->getKw()}%");
        }

        if(!empty($search->getMin())) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->getMin());
        }

        if(!empty($search->getMax())) {
            $query = $query
                ->andWhere('p.price <= :max')
                ->setParameter('max', $search->getMax());
        }

        if(!empty($search->getDiscount())) {
            $query = $query
                ->andWhere('p.discount is not null');
        }
       
        return $query->getQuery()->getResult();
    }
}
