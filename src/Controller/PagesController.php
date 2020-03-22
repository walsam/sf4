<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PagesController
{

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return new Response(
            $this->twig->render('/pages/Homepage.html.twig')
        );

    }

    /**
     * @Route("/About", name="About")
     */
    public function about()
    {
        return new Response(
            $this->twig->render('/pages/About.html.twig')
        );

    }
}