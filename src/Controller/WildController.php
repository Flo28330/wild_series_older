<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\ProgramSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


Class WildController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     * @Route("/wild", name="wild_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table'
            );
        }
        return $this->render('wild/index.html.twig',
            ['programs' => $programs]
        );

    }
    /**
     * @param string $slug
     * @Route("/show/{slug}", defaults={"slug" = null}, name="wild_show")
     * @return Response
     */
    public function show(?string $slug): Response
    {

        //<^[a-z0-9-]+$>

        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,

        ]);
    }

    /**
     * @Route("/wild/home/{categoryName}", name="show_category", defaults={"categoryName" = ""})
     * @param string $categoryName
     * @return Response
     */

    public function showByCategory(string $categoryName): Response
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category\'s name has been sent to find programs in programs table');
        }

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);
        if (!$category) {
            throw $this->createNotFoundException('No category found');
        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category], ['id' => 'DESC'], 3);
        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in category\'s table'
            );
        }
        return $this->render('wild/home.html.twig',
            [
                'programs' => $programs,
                'category' => $category,

            ]);
    }

    /**
     * @Route("/wild/season/{programName}", name="show_season_by_program", defaults={"programName" = ""},
     * requirements={"programName" = "[a-z0-9\-]+"})
     * @param string $programName
     * @return Response
     */
    public function showByProgram($programName): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => $programName]);
        if (!$program) {
            throw $this->createNotFoundException('No program found');
        }
        $seasons = $program->getSeasons();

        return $this->render('season/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }


    /**
     * @Route("/wild/season/{id}", name="show_episodes_by_season", defaults={"id" = ""},
     * requirements={"id" = "[0-9]+"})
     * @param int $id
     * @return Response
     */
    public function showBySeason($id): Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $id]);
        if (!$season) {
            throw $this->createNotFoundException('No season found');
        }

        $episodes = $season->getEpisodes();

        return $this->render('season/show.html.twig', [
            'season' => $season,
            'episodes' => $episodes
        ]);
    }


    /**
     * @Route("/wild/episode/{id}", name="wild_show_episode")
     * @param Episode $episode
     * @return Response
     */
    public function showByEpisode(Episode $episode): Response
    {
        $episode->getSeason()->getProgram();
        return $this->render('episode/show.html.twig', [
            'episode' => $episode,
        ]);
    }

}

