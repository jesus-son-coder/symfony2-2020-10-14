<?php

namespace Yoda\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Yoda\UserBundle\Entity\User;

class RegisterController extends Controller
{
  /**
   * @Route("/register", name="user_register")
   * @Template
   * @param Request $request
   * @return array
   */
    public function registerAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username','text')
            ->add('email','email')
            ->add('password','repeated', array(
              'type' => 'password',
            ))
            ->getForm()
        ;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $data = $form->getData();
          $user = new User();
          $user->setUsername($data['username']);
          $user->setEmail($data['email']);
          $user->setPassword($this->encodePassword($user, $data['password']));

          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();

          return $this->redirectToRoute('event');
        }

        return array('form' => $form->createView());
    }


    public function encodePassword(User $user, $plainPassword)
    {
      $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

      return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
}