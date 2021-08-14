<?php

namespace App\Database\Repository;

use App\Database\Entity\PostType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostType[]    findAll()
 * @method PostType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostType::class);
    }

    // /**
    //  * @return PostType[] Returns an array of PostType objects
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
    public function findOneBySomeField($value): ?PostType
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
