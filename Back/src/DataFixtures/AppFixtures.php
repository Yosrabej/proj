<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 20; $i++) {
            $user = new User();
            $user->setNom("user n°" . $i);
            $user->setPrenom("prenom");
            $user->setTypeContrat(true);
            $user->setEmail("nom".$i."@gmail.com");
            $user->setPassword("123");
            $user->setSupprimer("non");
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);

        $manager->flush();
    }
}
}
