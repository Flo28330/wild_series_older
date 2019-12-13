<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request) : Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->getDoctrine()->getManager()->persist($data);
            $this->getDoctrine()->getManager()->flush();
            // $data contains $_POST data
            // TODO : Faire une recherche dans la BDD avec les infos de $data…
        }
        return $this->render('category/index.html.twig',
            ['form' => $form->createView()]
        );
    }

}
