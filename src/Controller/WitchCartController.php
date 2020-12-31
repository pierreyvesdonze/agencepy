<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Cart;
use App\Repository\ArticleRepository;
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

        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            $userCart = $user->getCart();

            $witchProductId = $request->getContent();

            // On cherche le format du produit
            
            /**@var WitchFormat $newWitchProduct */
            $newWitchProduct = $witchFormatRepository->findOneBy([
                'id' => $witchProductId
            ]);

            // On vérifie si le produit existe déjà dans le panier de l'utilisateur
            $formatId = $newWitchProduct->getId();
            $cartId = $userCart->getId();
            $fetchExistingProduct = $articleRepository->findByFormatAndUserCart($cartId, $formatId);

            $message = null;
            if ($newWitchProduct->getStock() > 0) {

                if ($fetchExistingProduct) {
                    $article = $fetchExistingProduct[0];
                    $article->setQuantity($article->getQuantity() + 1);
                    $this->em->flush();
                } else {
                    $newArticle = new Article;
                    $newArticle->setCart($userCart);
                    $newArticle->setWitchFormatId($newWitchProduct->getId());
                    $newArticle->setArticleSize($newWitchProduct->getSize());
                    $newArticle->setArticlePrice($newWitchProduct->getPrice());
                    $newArticle->setQuantity(1);
                    $newArticle->setName($newWitchProduct->getWitchProduct()->getName());
                    $userCart->addArticle($newArticle);
                    $this->em->persist($newArticle);
                    $this->em->flush();

                    // On fait un test sur la création d'un nouvel Article;
                    $message = ('Nouvel article créé');
                }
            } else {
                $message = $this->translator->trans('stock.unavailable');
            }
            return new JsonResponse($message);
        }
    }

    /**
     * @Route("/witch/cart/pastille", name="witch_cart_pastille", methods={"GET","POST"}, options={"expose"=true})
     */
    public function updateCartPastille()
    {
        $user     = $this->getUser();
        $cartId   = $user->getCart()->getId();
        $cart     = $this->getDoctrine()->getRepository(Cart::class)->find($cartId);
        $articles = $cart->getArticles();

        $totalArticlesArray = [];
        foreach ($articles as $key => $value) {
            $totalArticlesArray[] = $value->getQuantity();
        }

        $message = (int)array_sum($totalArticlesArray);

        return new JsonResponse($message);
    }

    /**
     * @Route("/witch/cart", name="witch_cart")
     */
    public function witchCart(
        Request $request,
        ArticleRepository $articleRepository
    ): Response {
        if (null !== $this->getUser()) {
            $user = $this->getUser();
        } else {
            return $this->redirectToRoute('app_login');
        }

        /**@var Cart $cart */
        $cart = $user->getCart();
        dump($cart->getArticles());

        return $this->render('witch/cart.witch.html.twig', [
            'cart' => $cart,
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
