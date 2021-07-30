<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $article = new Articles();
            $article->setAuteur($faker->firstName())
                ->setContenu($faker->paragraph(5))
                ->setCreatedAt($faker->dateTimeBetween('-2 week'));
            $manager->persist($article);
        }

        $manager->flush();
    }
}
