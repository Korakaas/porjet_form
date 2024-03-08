<?php

namespace App\Repository;

use App\Entity\Pattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pattern>
 *
 * @method Pattern|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pattern|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pattern[]    findAll()
 * @method Pattern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pattern::class);
    }

    public function remove(Pattern $pattern): void
    {
        $this->getEntityManager()->remove($pattern);
        $this->getEntityManager()->flush();
    }
    /**
     * Retourne les patrons en fonction de leur catégorie
     * @return Pattern[] Returns an array of Pattern objects
     */
    public function findByCategory(int $categoryId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categories = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne les patrons en fonction de la laine
     *
     * @return Pattern[] Returns an array of Pattern objects
     */
    public function findByYarn(int $yarnId): array
    {
        return $this->createQueryBuilder('p')
        ->innerJoin('p.yarns', 'y')
            ->andWhere('y.id = :yarnId')
            ->setParameter('yarnId', $yarnId)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne les patrons en fonction d'un mot clé
     *
     * @return Pattern[] Returns an array of Pattern objects
     */
    public function findByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :keyword OR p.description LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword .'%')
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Pattern
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
