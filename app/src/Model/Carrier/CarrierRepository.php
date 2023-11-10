<?php

namespace App\Model\Carrier;

use App\Model\Carrier\Entity\Carrier;
use App\Infrastructure\PaginationRequest\Pagination\Filter;
use App\Infrastructure\PaginationRequest\Pagination\Sort;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\ORM\Pagination;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as QueryBuilderORM;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @extends ServiceEntityRepository<Carrier>
 *
 * @method Carrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carrier[]    findAll()
 * @method Carrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrierRepository extends ServiceEntityRepository
{
    protected const DEFAULT_SORT = [
        'COLUMN' => 'id',
        'DIRECTION' => 'ASC'
    ];

    public function __construct(
        ManagerRegistry               $registry,
        public EntityManagerInterface $entityManager,
        public PaginatorInterface     $paginator,
        public Connection             $connection,
        public DenormalizerInterface  $denormalizer
    )
    {
        parent::__construct($registry, Carrier::class);
    }

    public function paginate(PaginationRequestInterface $paginationRequest): PaginationInterface
    {

        $stmt = $this->getQuery($paginationRequest, [
            'c.id',
            'c.title',
            'c.weight_categoring',
            'c.price_uncategorized'


        ]);
        return new Pagination($this->paginator->paginate(
            $stmt,
            $paginationRequest->getPagination()->getPage(),
            $paginationRequest->getPagination()->getSize()
        ));
    }


    public function getQuery(PaginationRequestInterface $paginationRequest, array $select): QueryBuilder
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select($select)
            ->from('"carrier"', 'c');
        $this->setFilters($stmt, $paginationRequest->getFilter());
        $this->setSort($stmt, $paginationRequest->getSort());

        return $stmt;
    }

    private function setFilters(QueryBuilder $queryBuilder, Filter $filters): void
    {
        $filter = $filters->getFilters();

        if (isset($filter['weight_categoring'])) {
            $queryBuilder->andWhere("u.weight_categoring = :weight_categoring");
            $queryBuilder->setParameter(":weight_categoring", $filter['weight_categoring']);
        }

        if (isset($filter['id'])) {
            $queryBuilder->andWhere("u.id = :id");
            $queryBuilder->setParameter(":id", $filter['id']);
        }

    }

    protected function setSort(QueryBuilder $queryBuilder, Sort $sort): void
    {
        $column = $sort->getColumn() ?: static::DEFAULT_SORT['COLUMN'];
        $direction = $sort->getDirection() ?: static::DEFAULT_SORT['DIRECTION'];

        if ($column && $direction) {
            $queryBuilder->orderBy($column, $direction);
        }
    }

//    /**
//     * @return Carrier[] Returns an array of Carrier objects
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

//    public function findOneBySomeField($value): ?Carrier
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
