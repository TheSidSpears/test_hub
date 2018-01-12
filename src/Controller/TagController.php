<?php

namespace App\Controller;

use App\Entity\Tag;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
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
     * @Route("/tags", name="tag_list")
     */
    public function tagList(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Tag::class)->createFindAllQuery();

        $tags = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('tags/list.html.twig', [
            'tags' => $tags
        ]);
    }
}
