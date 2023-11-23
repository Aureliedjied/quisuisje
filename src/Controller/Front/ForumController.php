<?php

namespace App\Controller\Front;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="app_forum")
     */
    public function list(TopicRepository $topicRepository): Response
    {
        $topics = $topicRepository->findAll();

        return $this->render('forum/index.html.twig', [
            'topics' => $topics,
        ]);
    }
    /**
     * @Route("/forum/topic/{id}", name="app_forum_show")
     */
    public function showTopic(Topic $topic): Response
    {
        return $this->render('forum/show.html.twig', [
            'topic' => $topic,
        ]);
    }
}
