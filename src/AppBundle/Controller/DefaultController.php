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
    public function utilisateursAction()
    {

        /*$nuser=new fos_user.user_manager();
        $form=$this->createForm(RegistrationFormType::class,$nuser,array(
            'action'=>$this->generateUrl('add_user')
        ));*/


        /*$user=$this->getUser();
        if($user){*/
            $repository = $this->get('fos_user.user_manager');
            //$repository=$this->getDoctrine()->getRepository('User');
            $users=$repository->findUsers();
            return $this->render('@App/utilisateurs.html.twig',array('utilisateurs'=>$users));
        /*}else {
            return $this->render('@FOSUser/Security/login.html.twig');
        }*/

    }

    /**
     * @Route("/deleteUser/{id}", name="delete_user")
     */
    public function deleteAction( Request $request, $id = null )
    {
        $session=$request->getSession();
        if(!$id){
          $session->getFlashBag()->add('error',"l'utilisateur n'existe pas");
        }else {
            $repository = $this->get('fos_user.user_manager');
            $user = $repository->findUserBy(array('id'=>$id));
            dump($user);
            die('test');
            $repository->remove($user);
            $repository->flush();
            $session->getFlashBag()->add('error',"le personne est supprimé ");

        }
        return $this->forward('AppBundle:Default:utilisateurs');

    }
}
