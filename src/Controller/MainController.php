<?php


namespace App\Controller;


use App\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/")
     */
    public function homepageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository(Test::class)->findAll();

        return $this->render('main/homepage.html.twig', [
            'tests' => $tests
        ]);
    }
}