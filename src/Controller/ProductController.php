<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TestProduct;
use Doctrine\ORM\EntityManager;

class ProductController extends AbstractController
{



    #[Route('/product', name: 'product')]
    public function defaultAction(EntityManagerInterface $entityManager): Response
    {

        $repository = $entityManager->getRepository(TestProduct::class);

        $products = $repository->findAll();

        return $this->render('/product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/product/show/{id}')]
    public function detailAction(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(TestProduct::class)->find($id);

        return $this->render('/product/detail.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product/create')]
    public function createProduct(EntityManagerInterface $entityManager, Request $request): Response
    {
        $name = $request->query->get('name');
        $description = $request->query->get('description');

        $product = new TestProduct();
        $product->setName($name);
        $product->setComment($description);
        $product->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Berlin')));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('product');
    }


    #[Route('product/delete/{id}')]
    public function deleteProduct(EntityManagerInterface $entityManager, int $id): Response
    {

        $product = $entityManager->getRepository(TestProduct::class)->find($id);

        $entityManager->remove($product);
        $entityManager->flush();


        return $this->redirectToRoute('product');
    }
}
