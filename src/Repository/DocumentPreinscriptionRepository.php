<?php

namespace App\Repository;

use App\Entity\DocumentPreinscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocumentPreinscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentPreinscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentPreinscription[]    findAll()
 * @method DocumentPreinscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentPreinscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentPreinscription::class);
    }

    // /**
    //  * @return DocumentPreinscription[] Returns an array of DocumentPreinscription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DocumentPreinscription
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
