<?php

namespace App\Controller;

use App\Entity\WitchCategory;
use App\Form\Type\WitchFormatType;
use App\Repository\WitchFormatRepository;
use App\Repository\WitchProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        WitchProductRepository $witchProductRepository
    ) {
        $products = $witchProductRepository->findAll();

        return $this->render('witch/shop.witch.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/witch/shop/buy", name="witch_shop_buy", methods={"GET","POST"}, options={"expose"=true})
     */
    public function witchShopBuy(
        WitchFormatRepository $witchFormatRepository,
        Request $request
    ): JsonResponse {
        if ($request->isMethod('POST')) {
            $shopRequest = $request->getContent();
            $witchProductId = explode('-', $shopRequest);
          
            $witchProduct = $witchFormatRepository->findOneBy([
                'id' => $witchProductId
            ]);

            $session = $request->getSession();
            $articlesArray = $session->get('newArticle');
            if ($articlesArray == null){
              $articlesArray = [];
            }
            $articlesArray[] = $witchProduct;
            $session->set('newArticle', $articlesArray);

            return new JsonResponse($witchProduct);
        }
    }
}
