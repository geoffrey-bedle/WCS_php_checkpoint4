<?php


namespace App\DataFixtures;

use App\Entity\Show;
use Faker;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ShowFixtures extends Fixture
{
    const NAME = ['Le trapèze de la mort', 'Les clowns ensanglantés','L\'acrobate fou'  ,'Le jongleur du diable','L\'équilibre ou la mort'];
    const SPECIALITY = ['Trapèze', 'Clown', 'Acrobatie', 'Jonglerie', 'Equilibrisme'];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 4; $i++) {
            $show = new Show();
            $show->setName(self::NAME[$i]);
            $show->setType(self::SPECIALITY[$i]);
            $show->setDescription($faker->realText(200));
        }
        $manager->flush();
    }
}