<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Repository\ProductRepository;
use App\Entity\Product;



class PagesController
{
    private $session;

    public function __construct(Environment $twig, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->session = $session;

    }
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return new Response(
            $this->twig->render('/pages/Homepage.html.twig',[
                'products' => $productRepository->getLastThreeProducts(),
            ])
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