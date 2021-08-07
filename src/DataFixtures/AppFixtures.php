<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $password = $this->encoder->encodePassword($user, 'spirite');
        $user->setEmail('elessa@symf.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($password);
        $manager->persist($user); 
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
                    ->addCategorie($categorie)
                    ->setUser($user);
                   
                $manager->persist($article);

            }
        }
        

        $manager->flush();
    }
}
