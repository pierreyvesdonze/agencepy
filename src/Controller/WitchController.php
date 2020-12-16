<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WitchController extends AbstractController
{
    /**
     * @Route("/witch/home", name="witch_home")
     */
    public function witchHome(): Response
    {
        return $this->render('witch/index.witch.html.twig', []);
    }
}