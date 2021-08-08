<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    public function __construct(UserPasswordHasherInterface $hash)
    {
        $this->hash = $hash;
    }
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $this->hash->hashPassword($user, $user->getPassword());
            $user->setPassword($password)
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
