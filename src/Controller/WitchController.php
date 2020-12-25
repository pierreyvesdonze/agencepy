<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\WitchProduct;
use App\Form\Type\WitchAddToCartType;
use App\Form\Type\WitchFormatCollectionType;
use App\Form\Type\WitchFormatType;
use App\Repository\WitchFormatRepository;
use App\Repository\WitchProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class WitchController extends AbstractController
{
    private $translator;


    public function __construct(
        TranslatorInterface $translator,
        EntityManagerInterface $em
    ) {
        $this->translator = $translator;
        $this->em = $em;
    }

    /**
     * @Route("/witch/home", name="witch_home")
     */
    public function witchHome(
        WitchProductRepository $witchProductRepository
    ): Response {
        $witchProducts = $witchProductRepository->findAll();

        return $this->render('witch/index.witch.html.twig', [
            "witchProducts" => $witchProducts
        ]);
    }

    /**
     * @Route("/witch/shop", name="witch_shop")
     */
    public function witchShop(
        WitchProductRepository $witchProductRepository
    ): Response {
        $witchProducts = $witchProductRepository->findAll();

        return $this->render('witch/shop.witch.html.twig', [
            "witchProducts" => $witchProducts
        ]);
    }

    /**
     * @Route("/witch/shop/product/{id}", name="witch_shop_product", methods={"GET","POST"}, requirements={"id"="\d+"})
     * 
     */
    public function witchShopProduct(
        WitchProductRepository $witchProductRepository,
        WitchFormatRepository $witchFormatRepository,
        WitchProduct $witchProduct
    ) {
        $product = $witchProductRepository->findOneBy([
            'id' => $witchProduct->getId()
        ]);

        $user = $this->getUser();

        if (null == $user) {
            $customMessage = $this->translator->trans('login.cart_need_login');
            return $this->redirectToRoute('app_login');
        } else {
            $customMessage = $this->translator->trans('cart.added');
        }

        return $this->render('witch/product.witch.html.twig', [
            'product' => $product,
            'customMessage' => $customMessage,
        ]);
    }
}
