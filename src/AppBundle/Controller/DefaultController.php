<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
       /*$user=$this->getUser();
        if($user) {*/
            // replace this example code with whatever you need
            return $this->render('default/index.html.twig');
        /*}else {
            return $this->render('@FOSUser/Security/login.html.twig');
        }*/
    }

    /**
     * @Route("/utilisateurs", name="gestion_des_utilisateurs")
     */
    public function utilisateursAction(Request $request)
    {


            $repository = $this->get('fos_user.user_manager');
            //$repository=$this->getDoctrine()->getRepository('User');
            $utilisateurs=$repository->findUsers();
            return $this->render('@App/utilisateurs.html.twig',array('utilisateurs'=>$utilisateurs ));


    }

    /**
     * @Route("/deleteUser/{id}", name="delete_user")
     */
    public function deleteAction( Request $request, $id = null )
    {
        $session=$request->getSession();
        $repository = $this->get('fos_user.user_manager');
        if(!$repository->findUserBy(array('id'=>$id))){
          $session->getFlashBag()->add('error',"user not find");
        }else {

            $user = $repository->findUserBy(array('id'=>$id));
            /*dump($user);
            die('test');*/
            $repository->deleteUser($user);
            //$repository->flush();
            $session->getFlashBag()->add('success',"user deleted ");

        }
        return $this->forward('AppBundle:Default:utilisateurs');

    }


}
