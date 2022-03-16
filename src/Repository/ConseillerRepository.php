<?php

namespace App\Repository;

use App\Entity\Conseiller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conseiller|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conseiller|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conseiller[]    findAll()
 * @method Conseiller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConseillerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conseiller::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Conseiller $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Conseiller $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Conseiller[] Returns an array of Conseiller objects
    //  */
    
    public function findReferents()
    {
        return $this->createQueryBuilder('c')
            ->Where('c.referent = :true')
            ->setParameters([
                'true' => true
            ])
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Conseiller
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
