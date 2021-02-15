<?php

declare(strict_types=1);

namespace App\UI\Http\Web\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController extends AbstractRenderController
{
    /**
     * @Route(
     *     "/",
     *     name="home",
     *     methods={"GET"}
     * )
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function home(Security $security): Response
    {
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute("profile", [], 301);
        }

        return $this->render('home/index.html.twig');
    }
}
