<?php
/**
 *  Created with PhpStorm
 * by @hseka
 * Date : 29/01/2021
 * Time: 01:52
 **/

namespace Yoda\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterFormType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('username', 'text')
      ->add('email', 'email')
      ->add('plainPassword', 'repeated', array(
          'type' => 'password'
        )
      );
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Yoda\UserBundle\Entity\User',
    ));
  }

  public function getName()
  {
    return 'user_register';
  }
}