<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\WitchFormatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class WitchCartController extends AbstractController
{
    private $em;

    public function __construct(
        TranslatorInterface $translator,
        EntityManagerInterface $em
    ) {
        $this->translator = $translator;
        $this->em = $em;
    }

    /**
     * @Route("/witch/shop/buy", name="witch_shop_buy", methods={"GET","POST"}, options={"expose"=true})
     */
    public function witchShopBuy(
        WitchFormatRepository $witchFormatRepository,
        Request $request

    ): JsonResponse {

        if ($request->isMethod('POST')) {

            // if (null !== $this->getUser()) {

            //     /** @var \App\Entity\User $user */
            //     $user = $this->getUser();
            // }

            // if (null === $user->getCart()) {
            //     $userCart = new Cart;
            //     $userCart->setIsValid(false);
            //     $user->setCart($userCart);
            //     $this->em->persist($userCart);
            // } else {
            //     $userCart = $user->getCart();
            // }

            // $shopRequest = $request->getContent();
            // $witchProducts = explode('-', $shopRequest);
            // $witchProductId = $witchProducts[0];

            // $witchProduct = $witchFormatRepository->findOneBy([
            //     'id' => $witchProductId
            // ]);

            // $userCart->addArticle($witchProduct);
            // $this->em->flush();



            return new JsonResponse('oki');
        }
    }

    /**
     * @Route("/witch/cart", name="witch_cart")
     */
    public function witchCart(Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('newArticleArray');

        return $this->render('witch/cart.witch.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * @Route("/witch/shop/stock", name="witch_shop_stock", methods={"GET","POST"}, options={"expose"=true})
     */
    public function witchShopStock(
        WitchFormatRepository $witchFormatRepository,
        Request $request

    ): JsonResponse {

        return new JsonResponse('oki');
    }
}
