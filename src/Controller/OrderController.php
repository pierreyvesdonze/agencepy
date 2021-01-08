<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\Type\WitchOrderType;
use App\Repository\CartRepository;
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
        Request $request
    ) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->redirectToRoute('app_login');
        }

        $userCart = $user->getCart();
        $newOrder = new Order;
        $form = $this->createForm(WitchOrderType::class, $newOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fakeNumber = $form->get('fakeCardNumber')->getData();
            $fakeDate = $form->get('fakeDateExpiration')->getData();
            $fakeSecurityCode = $form->get('fakeSecurityCode')->getData();

            $validRegexCardNumber = "/(\d{4} *\d{4} *\d{4} *\d{4})/";

            if (!preg_match($validRegexCardNumber, $fakeNumber)) {
                dump('match');
                $customMessage = $this->addFlash('danger', $this->translator->trans('order.invalid_card'));
            } else {

                $newOrder->setCart($userCart);
                $newOrder->setFakeCardNumber($fakeNumber);
                $newOrder->setIsPayed(true);
                $newOrder->setFakeDateExpiration($fakeDate);
                $newOrder->setFakeSecurityCode($fakeSecurityCode);

                $this->em->persist($newOrder);
                $this->em->flush();

                return $this->redirectToRoute('witch_confirmation_order');
            }
        }

        return $this->render('order/new.witch.order.html.twig', [
            'form' => $form->createView(),
            'cart' => $userCart
        ]);
    }

    /**
     * @Route("/witch/order/confirmation", name="witch_confirmation_order", methods={"GET","POST"})
     */
    public function witchConfirmationOrder()
    {

        $user = $this->getUser();
        $userCart = $user->getCart();

        if (null === $user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('order/confirmation.witch.order.html.twig', [
            'cart' => $userCart
        ]);
    }
}
