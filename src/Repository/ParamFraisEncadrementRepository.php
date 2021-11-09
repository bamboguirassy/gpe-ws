<?php

namespace App\Repository;

use App\Entity\ParamFraisEncadrement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParamFraisEncadrement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParamFraisEncadrement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParamFraisEncadrement[]    findAll()
 * @method ParamFraisEncadrement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParamFraisEncadrementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParamFraisEncadrement::class);
    }

    // /**
    //  * @return ParamFraisEncadrement[] Returns an array of ParamFraisEncadrement objects
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
    public function findOneBySomeField($value): ?ParamFraisEncadrement
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
