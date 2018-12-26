<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\FosUser;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/utilisateurs", name="gestion_des_utilisateurs")
     */
    public function utilisateursAction()
    {

        $user=$this->getUser()->getId();
        if($user){
            $repository=$this->getDoctrine()->getRepository('FosUser');
            $users=$repository->findAll();
        }
        return $this->render('@App/utilisateurs',array('utilisateurs'=>$users));
    }
}
