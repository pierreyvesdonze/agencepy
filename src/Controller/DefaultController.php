<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
     /**
     * @Route("/", name="homepage", methods={"GET","POST"})
     */
    public function homepage(Request $request)
    {

        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre message a bien été envoyé, nous traiterons votre demande dans les plus brefs délais');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('main/homepage.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
