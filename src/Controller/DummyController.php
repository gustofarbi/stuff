<?php

namespace App\Controller;

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DummyController extends AbstractController
{
    /**
     * @Route("/dummy", name="dummy")
     */
    public function index(DocumentManager $dm)
    {
        $product = new Product('foo');

        $dm->persist($product);
        $dm->flush();

        return $this->render('dummy/index.html.twig', [
            'controller_name' => 'DummyController',
            'docs' => $dm->getRepository(Product::class)->findAll(),
        ]);
    }
}
