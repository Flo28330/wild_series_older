<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class WildController extends AbstractController
{
    /**
     * @Route("/index", name="app_index")
     */
    public function index() : Response
    {
        return $this->render('wild/index.html.twig', ['titre'=> 'Wild Séries']
        );
    }
}