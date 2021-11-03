<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralController extends AbstractController
{
    #[Route('/', name: 'app-home')]
    public function home(): Response
    {
        return $this->render('general/home.html.twig');
    }

    #[Route('/about', name: 'app-about')]
    public function about(): Response
    {
        return $this->render('general/about.html.twig');
    }

    #[Route('/contributors', name: 'app-contributors')]
    public function contributors(): Response
    {
        return $this->render('general/contributors.html.twig');
    }
}
