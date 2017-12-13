<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestsController extends Controller
{
    /**
     * @Route("/tests/{tag}", name = "tests_by_tag")
     */
    public function showTestsByTag($tag)
    {
        return $this->showTests($tag);
    }

    /**
     * @Route("/tests", name = "tests")
     */
    public function showTests(Request $request/*, $tag = null*/)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(SearchType::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $searchString = $form->getData()['search'];
            //dump($searchString);die();
            $tests = $em->getRepository(Test::class)->findByTag($searchString);
        } else {
            $tests = $em->getRepository(Test::class)->findAll();
        }

        return $this->render('tests/list.html.twig', [
            'tests' => $tests,
            'wanted_tag' => null,
            'searchForm' => $form->createView()
        ]);
    }
}
