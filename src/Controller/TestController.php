<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Test;
use App\Form\SearchType;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @Route("/tests/tag/{name}", name = "tests_by_tag")
     */
    public function testsByTag(Request $request, Tag $tag)
    {
        $tests = $this->getRepository()->findByTag($tag);
        //$tests = $this->getRepository()->findByTags([$tag]); //todo make it work, if possible
        $tests = $this->paginateTests($request, $tests);

        return $this->render('tests/by_tag_list.html.twig', [
            'tests' => $tests,
            'tag' => $tag,
            'searchForm' => $this
                ->createForm(SearchType::class)
                ->createView(),
        ]);
    }

    /**
     * @Route("/tests/search", name = "search")
     */
    public function searchList(Request $request)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->get('text')->getData();
        } else {
            $searchString = $request->query->get('text');
        }

        if ($searchString) {

            $tests = $this->getRepository()->searchByKeyword($searchString);
            $tests = $this->paginateTests($request, $tests);

            return $this->render('tests/search_list.html.twig', [
                'tests' => $tests,
                'searchForm' => $form->createView(),
            ]);
        } else {
            return $this->render('tests/search.html.twig', [
                'searchForm' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/tests", name = "tests")
     */
    public function list(Request $request)
    {
        $form = $this->createForm(SearchType::class);

        $query = $this->getRepository()->createFindAllQuery();
        $tests = $this->paginateTests($request, $query);

        return $this->render('tests/list.html.twig', [
            'tests' => $tests,
            'searchForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/test/{slug}/question", name = "test_question")
     */
    public function testQuestion(Request $request, Test $test)
    {
        return $this->render('test/question.html.twig');
    }

    /**
     * @Route("/test/{slug}", name = "test_preview")
     */
    public function testPreview(Request $request, Test $test)
    {
        return $this->render('test/preview.html.twig', [
            'test' => $test
        ]);
    }

    private function paginateTests(Request $request, $target): PaginationInterface
    {
        return $this->paginator->paginate(
            $target,
            $request->query->getInt('page', 1),
            10
        );
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Test::class);
    }


}
