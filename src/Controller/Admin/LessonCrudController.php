<?php

namespace App\Controller\Admin;

use App\Entity\EnrollLesson;
use App\Entity\Lesson;
use App\Entity\LessonStatus;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LessonCrudController extends AbstractCrudController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('content'),
            ChoiceField::new('status')->setChoices([
                LessonStatus::DRAFT => LessonStatus::DRAFT,
                LessonStatus::PUBLISHED => LessonStatus::PUBLISHED,
            ]),
            AssociationField::new('course')
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $users = $this->userRepository->findAll();
        foreach ($users as $user) {
            $enrollLesson = new EnrollLesson($user, $entityInstance);
            $entityManager->persist($enrollLesson);
            $entityManager->flush();
        }
    }
}
