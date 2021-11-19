<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\EnrollCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method EnRollCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnRollCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnRollCourse[]    findAll()
 * @method EnRollCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnrollCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnrollCourse::class);
    }

    public function findAllByUser(UserInterface $trainee): array
    {
        return $this->findBy(['trainee' => $trainee]);
    }

    public function findFinishedLessonBy(
        UserInterface $trainee,
        Course $course
    )
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            select el.finished_at from user u
            left join enroll_course ec on u.id = ec.trainee_id
            left join course c on ec.course_id = c.id
            left join lesson l on c.id = l.course_id
            left join enroll_lesson el on l.id = el.lesson_id
            where u.email = :email and c.slug = :courseSlug and el.trainee_id = u.id
        ';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([
            'email' => $trainee->getUserIdentifier(),
            'courseSlug' => $course->getSlug(),
        ]);
        return $result->fetchAllAssociative();
    }

    public function save(EnrollCourse $enrollCourse) {
        $this->getEntityManager()->persist($enrollCourse);
        $this->getEntityManager()->flush();
    }
}
