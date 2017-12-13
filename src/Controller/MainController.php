<?php


namespace App\Controller;


use App\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function showIndex()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository(Test::class)->findFivePopularPerMonth();

        return $this->render('main/homepage.html.twig', [
            'tests' => $tests
        ]);
    }
}