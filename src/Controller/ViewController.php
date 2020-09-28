<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/", name="home")
 */
class ViewController extends AbstractController
{
    /**
     * @return Response
     * @Route("/{vueRouting}", name="home", methods={"GET"})
     */
    public function index(){
        return $this->render('index.html.twig');
    }
}