<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WitchCartController extends AbstractController
{
    /**
     * @Route("/cart", name="witch_cart", methods={"GET","POST"})
     */
    public function tempCart(Request $request): Response
    {
        $tempArticles = $request->getSession()->get('newArticle');

        return $this->render('cart/temp.cart.html.twig', [
            
        ]);
    }
}
