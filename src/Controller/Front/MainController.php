<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('main/home.html.twig');
    }


    /**
     * @Route("/tuto", name="app_tuto")
     */
    public function rulesTuto(): Response
    {
        return $this->render('main/tutorial.html.twig');
    }




    /**
     * @Route("/quizz", name="app_quizz")
     */
    // public function quizz(): Response
    // {
    //     return $this->render('main/quizz.html.twig');
    // }


}


