<?php

namespace App\Repository;

use App\Entity\PaiementFraisEncadrement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaiementFraisEncadrement|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaiementFraisEncadrement|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaiementFraisEncadrement[]    findAll()
 * @method PaiementFraisEncadrement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaiementFraisEncadrementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaiementFraisEncadrement::class);
    }

    // /**
    //  * @return PaiementFraisEncadrement[] Returns an array of PaiementFraisEncadrement objects
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

    /*
    public function findOneBySomeField($value): ?PaiementFraisEncadrement
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
