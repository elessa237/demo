<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($j = 0; $j < 5; $j++) {
            $categorie = new Categorie();
            $categorie->setTitre($faker->sentence())
                ->setDescription($faker->paragraph(9))
                ->setCreatedAt($faker->dateTimeBetween('-2 week'));
            $manager->persist($categorie);

            for ($i = 0; $i < 4; $i++) {
                $article = new Articles();
                $article->setAuteur($faker->firstName())
                    ->setContenu($faker->paragraph(5))
                    ->setCreatedAt($faker->dateTimeBetween('-2 week'))
                    ->setImages('chat.jpg')
                    ->addCategorie($categorie);
                $manager->persist($article);
            }
        }
        

        $manager->flush();
    }
}
