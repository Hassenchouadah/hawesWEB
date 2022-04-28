<?php

namespace App\Repository;

use App\Entity\Hebergement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hebergement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hebergement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hebergement[]    findAll()
 * @method Hebergement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HebergementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hebergement::class);
    }


    /**
     *
     * Requête QueryBuilder
     */
    public function listHebergementRecherche(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.nom_hotel','DESC')
            ->getQuery()
            ->getResult()

            ;

    }
    public function countByNb(){

        $query = $this->getEntityManager()->createQuery("
           SELECT  p.nom as nom, count(p.idHbg) as nb FROM App\Entity\Hebergement p GROUP BY nom
       ");
        return $query->getResult();
    }

    public function findByIdP($nom)
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT p from APP\Entity\Hebergement p where p.idHbg = :nom")
            ->setParameter('nom',$nom);
        return $query->getResult();
    }

    /**
     *
     * Requête QueryBuilder
     */
    public function findbest(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT nomHotel,COUNT(idres)
                FROM App:Hebergement e JOIN App:Reservation r ON e.idHbg=r.idhebr
                GROUP BY idHbg ORDER BY COUNT(idres)'
            )

            ;
          

    }

    public function findEntitiesByString($str){

        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM App:Hebergement e
                WHERE e.nomHotel LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }
    

    




    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Hebergement $entity, bool $flush = true): void
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
    public function remove(Hebergement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Hebergement[] Returns an array of Hebergement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hebergement
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
