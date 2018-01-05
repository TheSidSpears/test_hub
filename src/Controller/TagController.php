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
     * @Route("/tags", name="tag_list")
     */
    public function tagList(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository(Tag::class)->findAll(); //todo popular first

        $tags = $paginator->paginate(
            $tags,
            $request->query->getInt('page', 1),
            100
        );

        return $this->render('tags/list.html.twig', [
            'tags' => $tags
        ]);
    }
}
