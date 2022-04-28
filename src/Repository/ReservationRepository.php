<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reservation $entity, bool $flush = true): void
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
    public function remove(Reservation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findUserReservations($idUser)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.iduser = :idUser')
            ->setParameter('idUser', $idUser)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findReservation($idres)
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
    public function findArchive()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.datedep <= :datenow')
            ->setParameter('datenow', new \DateTime('now'))
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getReservationsCount($month)
    {
        switch($month){
            case 0:
                $firstday=date('Y-1-01');
                $lastday = date('Y-1-t');
                break;
            case 1:
                $firstday=date('Y-2-01');
                $lastday = date('Y-2-t');
                break;
            case 2:
                $firstday=date('Y-3-01');
                $lastday = date('Y-3-t');
                break;
            case 3:
                $firstday=date('Y-4-01');
                $lastday = date('Y-4-t');
                break;
            case 4:
                $firstday=date('Y-5-01');
                $lastday = date('Y-5-t');
                break;
            case 5:
                $firstday=date('Y-6-01');
                $lastday = date('Y-6-t');
                break;
            case 6:
                $firstday=date('Y-7-01');
                $lastday = date('Y-7-t');
                break;
            case 7:
                $firstday=date('Y-8-01');
                $lastday = date('Y-8-t');
                break;
            case 8:
                $firstday=date('Y-9-01');
                $lastday = date('Y-9-t');
                break;
            case 9:
                $firstday=date('Y-10-01');
                $lastday = date('Y-10-t');
                break;
            case 10:
                $firstday=date('Y-11-01');
                $lastday = date('Y-11-t');
                break;
            case 11:
                $firstday=date('Y-12-01');
                $lastday = date('Y-12-t');
                break;
            default:
                dd("Erreur Data Chart");
                break;
        }
        $qb = $this->createQueryBuilder('r')
        ->andWhere('r.dateres >= :firstday')
        ->andWhere('r.dateres <= :lastday')
        ->setParameter('firstday', $firstday)
        ->setParameter('lastday', $lastday)
        ->getQuery()
        ->getResult();
        //dd($qb);
        $count = count($qb);
        return $count;
    }

        /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findCanceled()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.valide = :valide')
            ->setParameter('valide', -1)
            ->getQuery()
            ->getResult()
        ;
    }

        /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findAwaiting()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.valide = :valide')
            ->setParameter('valide', 0)
            ->getQuery()
            ->getResult()
        ;
    }

        /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findValidated()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.datedep >= :datenow')
            ->andWhere('r.valide = :valide')
            ->setParameter('datenow', new \DateTime('now'))
            ->setParameter('valide', 1)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
