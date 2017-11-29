<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUser extends Fixture
{
    const USER_PASSWORD = 'user';

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $author1 = new User();
        $author2 = new User();

        $author1->setFirstname('prenom1');
        $author1->setLastname('nom1');
        $author1->setEmail('author1@exemple.org');
        $author1->setIsAuthor(true);

        $author2->setFirstname('prenom2');
        $author2->setLastname('nom2');
        $author2->setEmail('author2@exemple.org');
        $author2->setIsAuthor(true);


        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setEmail('user@exemple.org');

        $password = $this->container->get('security.password_encoder')->encodePassword($user, self::USER_PASSWORD);
        $password1 = $this->container->get('security.password_encoder')->encodePassword($user, "author");

        $user->setPassword($password);
        $author1->setPassword($password1);
        $author2->setPassword($password1);
        $this->addReference('user', $user);

        $manager->persist($user);
        $manager->persist($author1);
        $manager->persist($author2);

        $manager->flush();
    }
}
