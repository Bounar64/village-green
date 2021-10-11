<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * Chiffre d'affaire HT Particulier
     *
     * @return void
     */
    public function TurnoverPart()
    {
        $query = $this
            ->createQueryBuilder('o');
        return $query
            ->select('sum(o.total)')
            ->join('o.user', 'u')
            ->where('u.type = 1')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Chiffre d'affaire HT Professionnel
     *
     * @return void
     */
    public function TurnoverPro()
    {
        $query = $this
            ->createQueryBuilder('o');
        return $query
            ->select('sum(o.total)')
            ->join('o.user', 'u')
            ->where('u.type = 0')
            ->getQuery()
            ->getResult();
    }
}
