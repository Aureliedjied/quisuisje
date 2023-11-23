<?php

namespace App\Controller\Front;

use App\Repository\PresentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Presentation;
use App\Form\PresentationType;

class PresentationController extends AbstractController
{
    /**
     * @Route("/presentations", name="app_presentation")
     */
    public function index(PresentationRepository $presentationRepository): Response
    {
        $presentations = $presentationRepository->findAll();

        return $this->render('presentation/index.html.twig', [
            'presentations' => $presentations,
        ]);
    }

    /**
     * @Route("/presentation/new", name="app_presentation_new")
     */
    public function new(Request $request, PresentationRepository $presentationRepository): Response
    {
        $presentation = new Presentation();
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $presentation->setUser($this->getUser());

            $presentationRepository->add($presentation, true);

            return $this->redirectToRoute('presentations_index');
        }

        return $this->renderForm('presentation/new.html.twig', [
            'form' => $form
        ]);
    }
}
