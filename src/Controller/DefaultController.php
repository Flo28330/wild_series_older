<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_home")
     */
    public function index() : Response
    {
        return new Response(
            '<html><tittle><h1>Bienvenue !</h1></tittle></html>'
        );
    }

}