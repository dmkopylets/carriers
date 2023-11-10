<?php

namespace App\Model\Carrier;

use App\Model\Carrier\Entity\CarrierWeightCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarrierWeightCategory>
 *
 * @method CarrierWeightCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarrierWeightCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarrierWeightCategory[]    findAll()
 * @method CarrierWeightCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrierWeightCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarrierWeightCategory::class);
    }

//    /**
//     * @return CarrierWeightCategory[] Returns an array of CarrierWeightCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CarrierWeightCategory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
