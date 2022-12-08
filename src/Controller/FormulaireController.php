<?php

namespace App\Controller;

use App\Entity\Chanson;
use App\Entity\Genre;
use App\Form\ChansonType;
use App\Form\GenreType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulaireController extends AbstractController
{
    #[Route('/formulaire/{type}', name: 'formulaire')]
    public function index(EntityManagerInterface $entityManager, Request $request, $type): Response
    {
        if($type == 'genre') {
            $genre = new Genre();
            $form = $this->createForm(GenreType::class, $genre);
        } elseif($type == 'chanson') {
            $chanson = new Chanson();
            $form = $this->createForm(ChansonType::class, $chanson);
        }
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($genre);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('formulaire/'.$type.'.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
