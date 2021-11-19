<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\EnrollLesson;
use App\Entity\LessonStatus;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnrollLesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnrollLesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnrollLesson[]    findAll()
 * @method EnrollLesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrollLessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnrollLesson::class);
    }

    public function findByCourseAndUser(Course $course, User $trainee)
    {
        return $this->createQueryBuilder('el')
            ->leftJoin('el.lesson', 'l')
            ->leftJoin('el.trainee', 't')
            ->leftJoin('l.course', 'c')
            ->andWhere('c.slug = :courseSlug')
            ->andWhere('t.email = :traineeEmail')
            ->andWhere('l.status = :status')
            ->setParameters([
                'courseSlug' => $course->getSlug(),
                'traineeEmail' => $trainee->getEmail(),
                'status' => LessonStatus::PUBLISHED,
            ])
            ->getQuery()
            ->getResult();
    }

    public function save(EnrollLesson $enrollLesson)
    {
        $this->getEntityManager()->persist($enrollLesson);
        $this->getEntityManager()->flush();
    }

    // /**
    //  * @return Lesson[] Returns an array of Lesson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lesson
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
