<?php

namespace App\Repository;

use App\Entity\Product;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
       $query = $this
        ->createQueryBuilder('p');

        if(!empty($search->getKw())) {
            $query = $query
                ->andWhere('p.brand LIKE :kw or p.label LIKE :kw') // recherche par marque ou modèle
                ->setParameter('kw', "%{$search->getKw()}%");
        }

        if(!empty($search->getMin())) {   
            if('p.discount' != NULL) {
                 $query = $query
                 ->andWhere('p.price - p.discount / 100 * p.price >= :min')
                ->setParameter('min', $search->getMin());
            }
            else {
                $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->getMin());
            }
                
        }

        if(!empty($search->getMax())) {
            if('p.disount' != NULL) {
                $query = $query
                ->andWhere('p.price - p.discount / 100 * p.price <= :max')
               ->setParameter('max', $search->getMax());
           }
           else {
               $query = $query
               ->andWhere('p.price <= :max')
               ->setParameter('max', $search->getMax());
           }
        }

        if(!empty($search->getDiscount())) {
            $query = $query
                ->andWhere('p.discount is not null');
        }

        $query = $query->getQuery(); // récupère la requête
        return $this->paginator->paginate(
            $query, 
            $search->page, /*page number*/
            12/*limit per page*/
        );
    }
}
