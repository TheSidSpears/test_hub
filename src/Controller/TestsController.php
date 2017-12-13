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
     * @Route("/tests", name = "tests")
     */
    public function list(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(SearchType::class);

        // only handles data on POST
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->getData()['search'];
        } elseif (!$searchString = $request->query->get('tag')) {
            $tests = $em->getRepository(Test::class)->findAll();
        }

        if ($searchString){
            $tests = $em->getRepository(Test::class)->findByNameOrTag($searchString);
        }

        return $this->render('tests/list.html.twig', [
            'tests' => $tests,
            'searchValue' => $searchString ?? '',
            'searchForm' => $form->createView()
        ]);
    }
}
