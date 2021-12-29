<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }
    public function findProjects($userId)
    {
        $query =$this->createQueryBuilder('projet')
            ->leftJoin('projet.collaborateur', 'collaborateur')
            ->where('collaborateur.id = :collaborateurId')
            ->setParameter('collaborateurId', $userId);
        return $query->getQuery()->getResult();
    }
    // /**
    //  * @return Projet[] Returns an array of Projet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function getProjectByIndex($index)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.supprimer = :val2')
            ->setParameter('val2', "non")
            ->setMaxResults(5)
            ->setFirstResult($index)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function getFilteredProjects($filteredValues)
    {
         return $this->createQueryBuilder('p')
            ->andWhere('p.nom LIKE :val OR p.surSite LIKE :val' )
            ->andWhere('p.supprimer = :val2')
            ->setParameter('val', '%'.$filteredValues.'%')
            ->setParameter('val2', "non")
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    
    /*
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}