<?php

namespace App\Repository;

use App\Entity\Product;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\PaginatorInterface;

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
    public function findSearch(SearchData $search)
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

        $query = $query->getQuery(); // récupère la requête
        return $this->paginator->paginate(
            $query, 
            1, /*page number*/
            3/*limit per page*/
        );
    }
}
