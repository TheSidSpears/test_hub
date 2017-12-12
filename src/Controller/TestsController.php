<?php

namespace App\Controller;

use App\Entity\Test;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestsController extends Controller
{
//    /**
//     * @Route("/tests/{tag}")
//     */
//    public function testsByTag($tag){
//        $em = $this->getDoctrine()->getManager();
//
//        $tests = $em->getRepository(Test::class)->findBy('');
//
//        return $this->render('tests/list.html.twig', [
//            'tests' => $tests
//        ]);
//    }
    /**
     * @Route("/tests", name="tests")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository(Test::class)->findAll();

        return $this->render('tests/list.html.twig', [
            'tests' => $tests
        ]);
    }
}
