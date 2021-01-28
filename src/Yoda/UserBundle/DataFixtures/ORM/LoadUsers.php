<?php
namespace Yoda\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function  load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('marco');
        $user->setPassword($this->encodePassword($user, 'userpass'));
        $user->setIsActive(false);
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('wayne');
        $admin->setPassword($this->encodePassword($admin, 'adminpass'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setIsActive(true);
        $manager->persist($admin);

        $manager->flush();
    }

    public function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
