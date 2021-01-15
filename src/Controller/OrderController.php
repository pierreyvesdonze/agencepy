<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderBackup;
use App\Entity\PostOrder;
use App\Form\Type\WitchOrderType;
use App\Repository\ArticleRepository;
use App\Repository\CartRepository;
use App\Repository\PostOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
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
     * @Route("/witch/order/new", name="witch_new_order", methods={"GET","POST"})
     */
    public function newOrder(
        CartRepository $cartRepository,
        Request $request,
        ArticleRepository $articleRepository
    ) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->redirectToRoute('app_login');
        }

        $userCart = $cartRepository->findCurrentCart(false);
        $newOrder = new Order;
        $form = $this->createForm(WitchOrderType::class, $newOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fakeNumber = $form->get('fakeCardNumber')->getData();
            $fakeDate = $form->get('fakeDateExpiration')->getData();
            $fakeSecurityCode = $form->get('fakeSecurityCode')->getData();

            $validRegexCardNumber = "/(\d{4} *\d{4} *\d{4} *\d{4})/";

            if (!preg_match($validRegexCardNumber, $fakeNumber)) {
                $customMessage = $this->addFlash('danger', $this->translator->trans('order.invalid_card'));
            } else {

                $newOrder->setCart($userCart);
                $newOrder->setFakeCardNumber($fakeNumber);
                $newOrder->setIsPayed(true);
                $newOrder->setFakeDateExpiration($fakeDate);
                $newOrder->setFakeSecurityCode($fakeSecurityCode);
            }

            $this->em->persist($newOrder);
            $this->em->flush();

            return $this->redirectToRoute('witch_confirmation_order');
        }


        return $this->render('order/new.witch.order.html.twig', [
            'form' => $form->createView(),
            'cart' => $userCart
        ]);
    }

    /**
     * @Route("/witch/order/confirmation", name="witch_confirmation_order", methods={"GET","POST"})
     */
    public function witchConfirmationOrder(
        CartRepository $cartRepository,
        ArticleRepository $articleRepository
    ) {

        $user = $this->getUser();
        if (null === $user) {
            return $this->redirectToRoute('app_login');
        }

        // On crée un postOrder pour avoir des archives de la commande puis on désactive le panier
        $userCart = $cartRepository->findCurrentCart(false);
        $tmpArray = [];
        $newOrderBackup = new OrderBackup;

        foreach ($userCart->getArticles() as $key => $article) {
            $tmpArray[$key]['article'] = $article;
            $tmpArray[$key]['name'] = $article->getName();
            $tmpArray[$key]['format'] = $article->getWitchFormatId();
            $tmpArray[$key]['quantity'] = $article->getQuantity();
            $tmpArray[$key]['price'] = $article->getArticlePrice();
            $tmpArray[$key]['user'] = $user;
            $tmpArray[$key]['backupOrder'] = $newOrderBackup;
        }

        foreach ($tmpArray as $key => $value) {
            $newPostOrder = new PostOrder;
            $newPostOrder->setProductName($value['name']);
            $newPostOrder->setProductFormat($value['format']);
            $newPostOrder->setProductPrice($value['price']);
            $newPostOrder->setUser($value['user']);
            $newPostOrder->setOrderBackup($value['backupOrder']);
            $this->em->persist($newPostOrder);
        }

        //$userCart->setIsValid(true);

        $this->em->flush();


        // On réinitialise le panier
        foreach ($userCart->getArticles() as $article) {
            $articleRepository->deleteAllFromCart($article);
            // $userCart->removeArticle($article);
        }
        $this->em->flush();

        return $this->render('order/confirmation.witch.order.html.twig', [
            'cart' => $userCart,
            'tmpArray' => $tmpArray
        ]);
    }

       /**
     * @Route("/witch/order/archive", name="witch_archive_order", methods={"GET","POST"})
     */
    public function witchArchiveOrder(
        PostOrderRepository $postOrderRepository
    )
    {
        $user = $this->getUser();
        if (null === $user) {
            return $this->redirectToRoute('app_login');
        }

        


        return $this->render('order/archive.witch.order.html.twig', [
    
        ]);
    }
}
