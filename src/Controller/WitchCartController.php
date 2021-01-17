<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Cart;
use App\Form\Type\WitchSubmitCartType as TypeWitchSubmitCartType;
use App\Form\WitchSubmitCartType;
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
		ArticleRepository $articleRepository,
		CartRepository $cartRepository

	): JsonResponse {

		if ($request->isMethod('POST')) {
			$user = $this->getUser();
			if (null == $user) {

				return $this->redirectToRoute('app_login');
			}

			// Si l'utilisateur n'a pas ou plus de panier on lui en crée un
			if (null == $user->getCarts()) {
				$userCart = new Cart;
				$userCart->setUser($user);
				$userCart->setIsValid(false);
				$this->em->persist($userCart);
				$this->em->flush();
			} else {
				$userCart = $cartRepository->findCurrentCart(false);
			}

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
					$message = ('Nouvel article ajouté');
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
	public function updateCartPastille(
		CartRepository $cartRepository
	) {
		$user = $this->getUser();
		if (null == $user) {

			return $this->redirectToRoute('app_login');
		}

		$cart     = $cartRepository->findCurrentCart(false);
		$articles = $cart->getArticles();

		if (null !== $articles) {

			$totalArticlesArray = [];
			foreach ($articles as $key => $value) {
				$totalArticlesArray[] = $value->getQuantity();
			}
			
			$message = (int)array_sum($totalArticlesArray);			
		}
			return new JsonResponse($message);
	}

	/**
	 * @Route("/witch/cart", name="witch_cart")
	 */
	public function witchCart(
		Request $request,
		CartRepository $cartRepository
	): Response {
		if (null !== $this->getUser()) {
			$user = $this->getUser();
		} else {
			return $this->redirectToRoute('app_login');
		}

		/**@var Cart $cart */
		$cart = $cartRepository->findCurrentCart(false);

		// On calcule le montant total pour garder la logique métier
		if (null !== $cart) {
			$articles = $cart->getArticles();

			$arr = [];
			$message = null;
			foreach ($articles as $key => $article) {
				
				if ($article->getQuantity() === 0) {
					$this->em->remove($article);
					$this->em->flush();
				}
				
				/**@var Article $article */
				$arr[$key] = $article->getArticlePrice() * $article->getQuantity();
			}
			$totalPrice =  array_sum($arr);
		} else {
			// return $this->redirectToRoute('witch_shop');
			$message = "Votre panier est vide";
			$totalPrice = 0;
		}


		$form = $this->createForm(TypeWitchSubmitCartType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			return $this->redirectToRoute('witch_new_order');
		}

		return $this->render('witch/cart.witch.html.twig', [
			'cart' => $cart,
			'totalPrice' => $totalPrice,
			'form' => $form->createView(),
			'message' => $message
		]);
	}

	/**
	 * @Route("/witch/shop/stock", name="witch_shop_stock", methods={"GET","POST"})
	 */
	public function witchShopStock(
		WitchFormatRepository $witchFormatRepository,
		Request $request,
		$userCart

	) {

		return $this->forward('App\Controller\WitchCartController::witchShopStock', [
			'userCart' => $userCart
		]);
	}

	/**
	 * @Route("/witch/cart/update", name="witch_cart_update", methods={"GET","POST"}, options={"expose"=true})
	 */
	public function witchShopUpdateCart(
		Request $request,
		ArticleRepository $articleRepository
	): JsonResponse {

		if ($request->isMethod('POST')) {
			$data             = json_decode($request->getContent(), true);
			$idFromAjax       = $data['id'];
			$quantityFromAjax = $data['quantity'];
			$type             = $data['type'];
			$productPrice     = $data['productPrice'];
			$currentTotal     = $data['currentTotal'];

			/**@Article $articleToUpdate */
			$articleToUpdate = $articleRepository->findOneBy([
				'id' => $idFromAjax
			]);

			if ($type === 'increase') {
				$newTotal = $currentTotal + $productPrice;
			}

			if ($type === 'decrease') {
				$newTotal = $currentTotal - $productPrice;
			}

			if (0 === $quantityFromAjax) {

				$this->em->remove($articleToUpdate);
			}

			$articleToUpdate->setQuantity($quantityFromAjax);
			$this->em->persist($articleToUpdate);
			$this->em->flush();

			$response = json_encode([
				'currentTotal' => $currentTotal,
				'newTotal' => $newTotal
			]);
		}


		return new JsonResponse('oki');
	}

	/**
	 * @Route("/witch/article/remove/", name="article_remove_from_cart", methods={"GET","POST"}, requirements={"id"="\d+"}, options={"expose"=true})
	 */
	public function removeArticle(
		Request $request,
		ArticleRepository $articleRepository
	) {
		if ($request->isMethod('POST')) {

			$articleId = $request->getContent();
			$article = $articleRepository->findOneBy([
				'id' => $articleId
			]);

			$this->em->remove($article);
			$this->em->flush();
			$message = $this->translator->trans('cart.cancel');
		}

		return new JsonResponse('oki');;
	}
}
