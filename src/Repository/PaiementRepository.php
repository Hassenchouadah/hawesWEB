<?php

namespace App\Repository;

use App\Entity\Paiement;
use App\Repository\ReservationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method Paiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paiement[]    findAll()
 * @method Paiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paiement::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Paiement $entity, bool $flush = true): void
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
    public function remove(Paiement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByIdRes(int $idRes )
    {   
        $sql = " 
        SELECT * FROM `paiement` WHERE `idRes` = {$idRes}";
    
        $stmt = $this->_em->getConnection()->prepare($sql);
        $result = $stmt->executeQuery()->fetchAllAssociative();
        return $result;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findUserPaiements($reservations)
    {
        $i=0;
        //$output 
        foreach ($reservations as $r){
            $sql = " 
            SELECT * FROM `paiement` WHERE `idRes` = {$r->getIdRes()}";
            echo $sql;
            $stmt = $this->_em->getConnection()->prepare($sql);
            $result = $stmt->executeQuery()->fetchAllAssociative();
            $output[$i] = array($result);  
            $i=$i+1;
            echo $i; 
        }
        //dd($output);
        return $output;
        //return $this->getEntityManager()->getRepository('reservation:ReservationRespository')->findUserReservations($id);
        //$listRes = findUserReservations($idUser);
        //return $listRes;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findPaiement($idres)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.idres = :idres')
            ->setParameter('idres', $idres)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

        /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findPaiementOnly($idpmt)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.idpmt = :idpmt')
            ->setParameter('idpmt', $idpmt)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

        /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findUserPaiementss($idRes)
    {
        return $this->createQueryBuilder('r')->andWhere('r.idRes = :idRes')->setParameter('idRes', $idRes)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Paiement[] Returns an array of Paiement objects
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
    public function findOneBySomeField($value): ?Paiement
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
