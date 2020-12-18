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
        return $this->render('witch/index.witch.html.twig', []);
    }

    /**
     * @Route("/witch/shop", name="witch_shop", methods={"GET","POST"})
     */
    public function witchShop(
        WitchProductRepository $witchProductRepository,
        Request $request
    ) {
        $products = $witchProductRepository->findAll();

        if (isset($_POST)) {
            $session = $request->getSession();
            $articlesArray = $session->get('newArticle');
            if ($articlesArray == null){
              $articlesArray = [];
            }
            $articlesArray[] = $_POST;
            $session->set('newArticle', $articlesArray);
            dump($session);
        }

        return $this->render('witch/shop.witch.html.twig', [
            'products' => $products,
        ]);
    }
}
