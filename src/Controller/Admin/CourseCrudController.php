<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\EnrollCourse;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CourseCrudController extends AbstractCrudController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Course::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $users = $this->userRepository->findAll();
        foreach($users as $user) {
            $enrollCourse = new EnrollCourse($user, $entityInstance);
            $entityManager->persist($enrollCourse);
            $entityManager->flush();
        }
    }
}
