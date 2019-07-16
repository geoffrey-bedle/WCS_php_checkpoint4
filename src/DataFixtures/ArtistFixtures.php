<?php


namespace App\DataFixtures;

use App\Entity\Artist;
use Faker;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArtistFixtures extends Fixture
{
    const SPECIALITIES = ['Trapèze', 'Jonglerie', 'Acrobatie aérienne', 'Equilibrisme', 'Clown'];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {

            $artist = new Artist();

            $artist->setLastname($faker->lastName);
            $artist->setFirstname($faker->firstName);

            $artist->setSpeciality(self::SPECIALITIES[array_rand(self::SPECIALITIES)]);
            $artist->setNickname($artist->getSpeciality().' Circus');
            $manager->persist($artist);
        }
        $manager->flush();
    }
}