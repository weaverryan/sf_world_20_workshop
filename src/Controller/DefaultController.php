<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    public function securePage(Request $request, Security $security)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ('json' === $request->getPreferredFormat()) {
            return new JsonResponse([
                'email' => $this->getUser()->getEmail(),
                'roles' => $security->getToken()->getRoleNames(),
            ]);
        }

        return $this->render('default/secure.html.twig');
    }
}
