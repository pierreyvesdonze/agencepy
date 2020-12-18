<?php

namespace App\Controller;

use App\Entity\WitchCategory;
use App\Form\Type\WitchFormatType;
use App\Repository\WitchProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WitchController extends AbstractController
{
    /**
     * @Route("/witch/home", name="witch_home")
     */
    public function witchHome(): Response
    {
        return $this->render('witch/index.witch.html.twig', [

        ]);
    }

     /**
     * @Route("/witch/shop", name="witch_shop", methods={"GET","POST"})
     */
    public function witchShop(
        WitchProductRepository $witchProductRepository,
        Request $request
        ) 
    {
        $products = $witchProductRepository->findAll();

        $formatForm = $this->createForm(WitchFormatType::class);
        $formatForm->handleRequest($request);

        if ($formatForm->isSubmitted() && $formatForm->isValid()) {

            $this->addFlash('success', 'Votre article a bien été ajouté au panier');
        }

        return $this->render('witch/shop.witch.html.twig', [
            'products' => $products,
            'formatForm' => $formatForm->createView()
        ]);
    }
}