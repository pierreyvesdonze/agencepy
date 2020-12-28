<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Cart;
use App\Repository\ArticleRepository;
use App\Repository\CartRepository;
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
        Request $request,
        ArticleRepository $articleRepository

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

            // On cherche le format du produit
            $newWitchProduct = $witchFormatRepository->findOneBy([
                'id' => $witchProductId
            ]);

            $existingProduct = $articleRepository->findOneBy([
                'witchFormatId' => $newWitchProduct->getId()
            ]);

            $message = null;
            if ($newWitchProduct->getStock() > 0) {

                if ($existingProduct) {
                    $existingProduct->setQuantity($existingProduct->getQuantity() + 1);
                    $this->em->flush();
                } else {
                    $newArticle = new Article;
                    $newArticle->setCart($userCart);
                    $newArticle->setWitchFormatId($newWitchProduct->getId());
                    $newArticle->setQuantity(1);
                    $newArticle->setName($newWitchProduct->getWitchProduct()->getName());
                    $userCart->addNewArticle($newArticle);
                    $this->em->persist($newArticle);
                    $this->em->flush();

                    // Gestion de la pastille indiquant la quantité d'articles dans le panier
                    $message = (int)count($userCart->getNewArticles());

                    // // Gestion de la pastille indiquant la quantité d'articles dans le panier
                    // $quantity = $userCart->getQuantity();
                    // $totalArticlesArray = [];
                    // foreach ($quantity as $key => $article) {
                    //     $totalArticlesArray[$key] = $article;
                    // }

                    // // $message = array_sum($totalArticlesArray);
                    // $message =  array_sum(array_column($totalArticlesArray, $key));
                }
            } else {
                $message = $this->translator->trans('stock.unavailable');
            }

            return new JsonResponse($message);
        }
    }

    /**
     * @Route("/witch/cart", name="witch_cart")
     */
    public function witchCart(
        Request $request,
        ArticleRepository $articleRepository
    ): Response {
        $user = $this->getUser();
        $cart = $user->getCart();

        $articles = $articleRepository->findAllArticlesByCart($cart->getId());

        dump($articles);

        return $this->render('witch/cart.witch.html.twig', [
            'cart' => $cart,
            'articles' => $articles
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
