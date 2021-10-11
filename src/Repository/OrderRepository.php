<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
            ->select('sum(o.total * 400)')
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
            ->select('sum(o.total * 200)')
            ->join('o.user', 'u')
            ->where('u.type = 0')
            ->getQuery()
            ->getResult();
    }

    /**
     * Calcul du délai moyen des commandes particulier
     *
     * @return void
     */
    public function AverageTimePart()
    {
        $query = $this
            ->createQueryBuilder('o');
        return $query
            ->select('sum(DATE_DIFF(o.dateSent, o.datePayment)) / count(DATE_DIFF(o.dateSent, o.datePayment))')
            ->join('o.user', 'u')
            ->where('u.type = 1')   
            ->getQuery()
            ->getResult();

    }

    /**
     * Calcul du délai moyen des commandes professionnel
     *
     * @return void
     */
    public function AverageTimePro()
    {
        $query = $this
            ->createQueryBuilder('o');
        return $query
            ->select('sum(DATE_DIFF(o.dateSent, o.datePayment)) / count(DATE_DIFF(o.dateSent, o.datePayment))')
            ->join('o.user', 'u')
            ->where('u.type = 0')
            ->getQuery()
            ->getResult();
    }
}
