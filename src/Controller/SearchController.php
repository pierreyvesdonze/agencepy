<?php

namespace App\Controller;

use App\Entity\WitchProduct;
use App\Form\Type\SearchType;
use App\Repository\WitchProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/recipe/api", name="searchApi", options={"expose"=true})
     */
    public function findProduct(
        WitchProductRepository $witchProductRepository,
        Request $request
    ) {
        if ($request->isXmlHttpRequest()) {
            $data                = json_decode($request->getContent());
            $products            = $witchProductRepository->findProductByName($data);
            $productsArray       = [];

            foreach ($products as $product) {
                $productsArray[] = $product;
            }
            return new JsonResponse($productsArray);
        }
        return $this->render('search/result.search.html.twig', []);
    }

    public function searchBarAction(
        Request $request,
        WitchProductRepository $witchProductRepository
    ): Response {
        $search = [];
        $form = $this->createForm(SearchType::class,  $search, [
            'action' => $this->generateUrl('search_transform'),
        ]);

        $form->handleRequest($request);
        $errors =  $form->getErrors(true, false);

        if ($form->isSubmitted() && $form->isValid()) {
            $data     = $form->getData();
            $products = $witchProductRepository->findProductByName($data);

            return $this->redirectToRoute('witch_products_list', [
                'products' => $products
            ]);
        }
        return $this->render('search/searchbar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/transformsearch", name="search_transform")
     */
    public function transformAction(
        Request $request
    ): Response {
        $form = $this->createForm(SearchType::class, null, [
            'action' => $this->generateUrl('search_transform'),
        ]);

        $witchProductRepository = $this->getDoctrine()->getRepository(WitchProduct::class);

        return $this->saveSearch(
            $request,
            $form,
            $witchProductRepository
        );
    }

    /**
     * @param $form
     */
    protected function saveSearch(
        Request $request,
        FormInterface $form,
        WitchProductRepository $witchProductRepository
    ) {
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $data       = $form->getData()['text'];
            $products   = $witchProductRepository->findProductByName($data);

            if (!$products) {
                $this->addFlash("error", "Aucun produit n'a été trouvé :/ ");
            }

            return $this->render('witch/list.witch.html.twig', [
                'request'    => $request,
                'products'   => $products,
            ]);
        }
        return new RedirectResponse($this->generateUrl('homepage'));
    }
}
