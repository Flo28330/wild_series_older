<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class WildController extends AbstractController
{
    /**
     * @Route("wild/index", name="app_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', ['titre' => 'Wild Séries']
        );
    }

    /**
     * @Route("/wild/show/{slug}",
     * requirements={"slug": "[a-z0-9\-]*"},
     * name="wild_index")
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        if ($slug == "") {
            "Aucune série sélectionnée, veuillez choisir une série";
            } else {
            $slug = str_replace('-', ' ', $slug);
            $slug = ucwords($slug);
        }

        return $this->render('/wild/show.html.twig', [
            'slug' => $slug,
        ]);
    }
}


