<?php

namespace App\Controller;

use App\Repository\WitchFormatRepository;
use App\Repository\WitchProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class WitchController extends AbstractController
{
    private $translator;

    public function __construct(
        TranslatorInterface $translator
        )
    {
        $this->translator = $translator;
    }

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
        $user = $this->getUser();

        if (null == $user) {
            $customMessage = $this->translator->trans('login.cart_need_login');
        } else {
            $customMessage = 'null';
        }

        return $this->render('witch/shop.witch.html.twig', [
            'products' => $products,
            'customMessage' => $customMessage
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
            $witchProducts = explode('-', $shopRequest);
            $witchProductId = $witchProducts[0];

            $witchProduct = $witchFormatRepository->findOneBy([
                'id' => $witchProductId
            ]);


            // Session option
            // $session = $request->getSession();
            // $articlesArray = $session->get('newArticle');
            // if ($articlesArray == null){
            //   $articlesArray = [];
            // }
            // $articlesArray[] = $witchProduct;
            // $session->set('newArticle', $articlesArray);
       

            return new JsonResponse('oki');
        }
    }
}
