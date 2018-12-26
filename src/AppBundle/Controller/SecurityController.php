<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Doctrine\UserManager;

class SecurityController extends Controller
{

    /**
     * @Route("/addUser", name="add_user")
     */
    public function addAction(Request $request)
    {
        $password=$request->request->get('password');
        $confirmPassword=$request->request->get('confirmPassword');

        $session = $request->getSession();
        $userManager = $this->container->get('fos_user.user_manager');
        if($password==$confirmPassword) {


            $user = $userManager->createUser();

            $user->setUsername($request->request->get('username'));
            $user->setRoles(array('ROLE_ADMIN'));
            $user->setEmail($request->request->get('email'));
            $user->setPlainPassword($request->request->get('password'));
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $session->getFlashBag()->add('success', "user added ");
        }else{
            $session->getFlashBag()->add('error', "Some Thing Wrong ");
        }
        return $this->forward('AppBundle:Default:utilisateurs');
    }

    /**
     * @Route("/updateUser/{id}",name="update_user")
     */
    public function updateAction(Request $request,$id)
    {
        $session=$request->getSession();
        $repository = $this->get('fos_user.user_manager');

        $user=$repository->findUserBy(array('id'=>$id));
        $user->setUsername($request->request->get('username'));
        $user->setEmail($request->request->get('email'));

        $this->get('fos_user.user_manager')->updateUser($user, false);
        $this->getDoctrine()->getManager()->flush();
        $session->getFlashBag()->add('success', "user updated");
        return $this->forward('AppBundle:Default:utilisateurs');
    }

    /**
     * @Route("/activeDesactive/{id}/{enabled}", name="active_desactive")
     */
    public function activeDesactiveAction($id,$enabled=null,Request $request)
    {
        $session=$request->getSession();
        $repository = $this->get('fos_user.user_manager');

        $user=$repository->findUserBy(array('id'=>$id));
        /*$p=$user->Enabled;
        dump($p);
        die('test');*/
        if(!$enabled)
        {
            $user->setEnabled(true);
            $session->getFlashBag()->add('success', "user Active");
        }else{
            $user->setEnabled(false);
            $session->getFlashBag()->add('success', "user Desactive");
        }
        $this->get('fos_user.user_manager')->updateUser($user, false);
        $this->getDoctrine()->getManager()->flush();
        return $this->forward('AppBundle:Default:utilisateurs');

    }
}
