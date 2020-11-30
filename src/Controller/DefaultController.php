<?php

namespace App\Controller;

use App\Entity\User;
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
            'globalPassword' => User::GLOBAL_DEFAULT_PASSWORD,
        ]);
    }

    /**
     * @Route("/secure", name="app_secure")
     */
    public function securePage()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('default/secure.html.twig');
    }
}
