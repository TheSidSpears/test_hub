<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Test;
use App\Form\SearchType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    /**
     * @Route("/tests/tag/{name}", name = "tests_by_tag")
     */
    public function testsByTag(Request $request, PaginatorInterface $paginator, Tag $tag)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $tests = $em->getRepository(Test::class)->findByTag($tag);

        $pagination = $paginator->paginate(
            $tests,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('tests/list.html.twig', [
            'tests' => $pagination ?? $tests,
            'searchForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tests/search", name = "search")
     */
    public function searchList(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->getData()['text'];
        } else {
            //ERROR
            //$searchString = $request->query->get('tag');
        }

        if ($searchString) {
//            returns error: You cannot add children to a submitted form
//            $form->add('search', null, [
//                'data' => $searchString
//            ]);
            $tests = $em->getRepository(Test::class)->findByNameOrTagInclusions($searchString);
        } else {
            //ERROR
            //$tests = $em->getRepository(Test::class)->findAll();
        }

        $pagination = $paginator->paginate(
            $tests,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('tests/list.html.twig', [
            'tests' => $pagination ?? $tests,
            'searchForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tests", name = "tests")
     */
    public function list(Request $request, PaginatorInterface $paginator)
    {
        $form = $this->createForm(SearchType::class);
        $em = $this->getDoctrine()->getManager();
        $tests = $em->getRepository(Test::class)->findAll();

        $pagination = $paginator->paginate(
            $tests,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('tests/list.html.twig', [
            'tests' => $pagination ?? $tests,
            'searchForm' => $form->createView(),
        ]);
    }
}
