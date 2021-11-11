<?php

namespace App\Repository;

use App\Entity\EnrollCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
