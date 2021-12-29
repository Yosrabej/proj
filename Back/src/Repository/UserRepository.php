<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByExampleField($value)

    {

        return $this->createQueryBuilder('u')

            ->andWhere('u.roles LIKE :val')

            ->andWhere('u.supprimer = :val2')

            ->setParameter('val', '%'.$value.'__')

            ->setParameter('val2', "non")

            ->getQuery()

            ->getResult()

        ;

    }


    public function getUserByIndex($index)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.supprimer = :val2')
            ->setParameter('val2', "non")
            ->setMaxResults(5)
            ->setFirstResult($index)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function getUsers($filteredValues)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.nom LIKE :val OR u.prenom LIKE :val OR u.email LIKE :val OR u.roles LIKE :val2')
            ->andWhere('u.supprimer = :val3')
            ->setParameter('val', '%'.$filteredValues.'%')
            ->setParameter('val2', '%'.$filteredValues.'__')
            ->setParameter('val3', "non")
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

