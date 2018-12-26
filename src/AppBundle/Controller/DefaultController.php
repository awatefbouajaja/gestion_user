<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\User;

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
            $repository = $this->get('fos_user.user_manager');
            //$repository=$this->getDoctrine()->getRepository('User');
            $users=$repository->findUsers();
        }
        return $this->render('@App/utilisateurs.html.twig',array('utilisateurs'=>$users));
    }
}
