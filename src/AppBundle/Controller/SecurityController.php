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
}
