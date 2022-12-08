<?php

namespace App\Repository;

use App\Entity\ChansonRecherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChansonRecherche>
 *
 * @method ChansonRecherche|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChansonRecherche|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChansonRecherche[]    findAll()
 * @method ChansonRecherche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChansonRechercheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChansonRecherche::class);
    }

    public function save(ChansonRecherche $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChansonRecherche $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ChansonRecherche[] Returns an array of ChansonRecherche objects
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

//    public function findOneBySomeField($value): ?ChansonRecherche
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
