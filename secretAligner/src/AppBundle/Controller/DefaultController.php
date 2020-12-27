<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $data = $em->getRepository('AppBundle:Todo')->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'data' => $data,
        ]);
    }
}
