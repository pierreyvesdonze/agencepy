<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
     /**
     * @Route("/", name="homepage", methods={"GET","POST"})
     */
    public function homepage()
    {
        $user = $this->getUser();
        return $this->render('main/homepage.html.twig', [
            'user' => $user
        ]);
    }
}
