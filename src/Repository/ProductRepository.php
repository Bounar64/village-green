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
            ->createQueryBuilder('p')
            ->select('p', 'sc')
            ->join('p.subCategory', 'sc')
            ->where('sc.label = :url_label')
            ->setParameter('url_label', $search->url_label);

        if(!empty($search->getKeyword())) {
            $query = $query
                ->andWhere('p.brand LIKE :keyword or p.label LIKE :keyword') // recherche par marque ou modèle
                ->setParameter('keyword', "%{$search->getKeyword()}%");
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
            8/*limit per page*/
        );
    }

    public function countResult()
    {
        $query = $this->createQueryBuilder('p');
        return $query
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    } 


    public function priceTTC()
    {
        $query = $this->createQueryBuilder('p');
        return $query
            ->select('(p.price + (20 / 100 * p.price))')
            ->getQuery()
            ->getResult();
    } 

    /**
     * Affiche les produits en fonction des mots clés (admin)
     *
     * @return void
     */
    public function searchFulltext($key)
    {
        $query = $this
            ->createQueryBuilder('p');
            if($key != null) {
                $query = $query
                    ->where('MATCH_AGAINST(p.label, p.shortLabel, p.brand, p.reference) AGAINST (:key boolean) > 0') // boolean > 0 = l'extension de doctrine existe dans la documentation officiel pour vérifier si on a une réponse à notre requête
                        ->setParameter('key', '*'.$key.'*'); // ajout des * pour une recherche approximative comme pour %
                }

                return $query->getQuery()->getResult();
    }
}
