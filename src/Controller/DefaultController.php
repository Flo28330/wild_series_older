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
        return $this->render('wild/home.html.twig', ['test'=>'Bienvenue !']

        );
    }

}