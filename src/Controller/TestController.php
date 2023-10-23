<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TestProduct;


class TestController extends AbstractController
{

    public function testAction(int $number): Response
    {
        // get the recent articles somehow (e.g. making a database query)

        dd($number);


        return new Response('hi');
    }
}
