<?php

namespace App\Controller;

use App\Entity\App;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoryController extends AbstractController
{
    /**
     * @Route("/story", name="story")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(App::class);
        
        return $this->render('story/index.html.twig', [
            'stories' => $repository->findAll()
        ]);
    }
}
