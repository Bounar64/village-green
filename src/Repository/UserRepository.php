<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    /**
     * Permet de mettre à jour le mot de passe de l'utilisateur si l'algo venait à changer 
     */
   public function upgradePassword(UserInterface $user, string $newHashedPassword): void 
   {
       if(!$user instanceof User) {
           throw new UnsupportedUserException(sprintf('Instance of "%s" are not supported.', \get_class($user)));
       }

       $user->setPassword($newHashedPassword);
       $this->_em->persist($user);
       $this->_em->flush();
   }
}
