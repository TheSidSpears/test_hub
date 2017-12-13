<?php

namespace App\Controller;

use App\Entity\Test;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestsController extends Controller
{
    /**
     * @Route("/tests/{tag}", name = "tests_by_tag")
     */
    public function testsByTag($tag)
    {
        $em = $this->getDoctrine()->getManager();
        $tests = $em->getRepository(Test::class)->findByTag($tag);

        return $this->render('tests/list.html.twig', [
            'tests' => $tests,
            'wanted_tag' => $tag
        ]);
    }

    /**
     * @Route("/tests", name = "tests")
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
