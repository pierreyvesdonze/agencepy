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
     * @Route("/witch/order/new", name="witch_new_order", methods={"GET","POST"}, options={"expose"=true})
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

            $validRegexCardNumber = "/(\d{4} *\d{4} *\d{4} *\d{4})/";

            if (!preg_match($validRegexCardNumber, $fakeNumber)) {
                dump('match');
                $customMessage = $this->addFlash('danger', $this->translator->trans('order.invalid_card'));
            } else {
                return $this->redirectToRoute('order/confirmation.witch.order.html.tig
                ');
            }
        }

        return $this->render('order/new.witch.order.html.twig', [
            'form' => $form->createView(),
            'cart' => $userCart
        ]);
    }
}
