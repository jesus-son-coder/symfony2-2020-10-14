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
        $user = new User();
        $user->setUsername('Leia');

        $form = $this->createFormBuilder($user, array(
          'data_class' => 'Yoda\UserBundle\Entity\User',
        ))
            ->add('username','text')
            ->add('email','email')
            ->add('plainPassword','repeated', array(
              'type' => 'password',
            ))
            ->getForm()
        ;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $user = $form->getData();

          $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

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