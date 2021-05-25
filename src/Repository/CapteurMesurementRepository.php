<?php

namespace App\Repository;

use App\Entity\CapteurMesurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CapteurMesurement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CapteurMesurement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CapteurMesurement[]    findAll()
 * @method CapteurMesurement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapteurMesurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CapteurMesurement::class);
    }

    // /**
    //  * @return CapteurMesurement[] Returns an array of CapteurMesurement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CapteurMesurement
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
