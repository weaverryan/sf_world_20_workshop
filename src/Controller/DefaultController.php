<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(UserRepository $userRepository)
    {
        return $this->render('default/homepage.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
