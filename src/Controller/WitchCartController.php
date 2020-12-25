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

        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            if (null === $user->getCart()) {
                $userCart = new Cart;
                $userCart->setIsValid(false);
                $user->setCart($userCart);
                $this->em->persist($userCart);
            } else {
                $userCart = $user->getCart();
            }

            $witchProductId = $request->getContent();

            $newWitchProduct = $witchFormatRepository->findOneBy([
                'id' => $witchProductId
            ]);

            $message = 'null'; 
            if ($newWitchProduct->getStock() > 0) {
                $userCart->addArticle($newWitchProduct);
                $this->em->persist($userCart);
                $this->em->flush();
            } else {
                $message = $this->translator->trans('stock.unavailable');
            }

            return new JsonResponse($message);
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
