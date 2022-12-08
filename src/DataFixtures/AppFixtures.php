<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Chanson;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // php bin/console doctrine:fixture:load
        // composer require fakerphp/faker
        $faker = Factory::create('fr_BE');

        for ($i = 0; $i < 100; $i++) {
            $chanson = new Chanson;
            $chanson
                ->setAuteur($faker->name())
                ->setTitre($faker->sentences(1, true))
                ->setNomAlbum($faker->name())
                ->setParoles($faker->sentences(4, true))
                ->setGenreId($faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9]));
            $manager->persist($chanson);
        }

        $manager->flush();
    }
}


