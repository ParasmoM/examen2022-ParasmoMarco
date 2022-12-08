<?php

namespace App\Controller;

use App\Entity\Chanson;
use App\Entity\Genre;
use App\Entity\ChansonRecherche;
use App\Form\ChansonType;
use App\Form\ChansonRechercheType;
use App\Form\GenreType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/dashboard{order}', name: 'show_dashboard')]
    public function dashboard(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request, $order = 'id'): Response
    {
        $repository = $entityManager->getRepository(Chanson::class);

        $recherche = new ChansonRecherche();
        $form = $this->createForm(ChansonRechercheType::class, $recherche);
        $form->handleRequest($request);

        $chansons = $paginator->paginate(
            $repository->orderBy($order, $recherche),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('home/dashboard.html.twig', [
            'nomTab' => 'des chansons',
            'chansons' => $chansons,
            'chanson' => '',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/genre{order}', name: 'show_dashboard_genre')]
    public function dashboardGenre(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request, $order = 'id'): Response
    {
        $repository = $entityManager->getRepository(Genre::class);

        // $recherche = new ChansonRecherche();
        // $form = $this->createForm(ChansonRechercheType::class, $recherche);
        // $form->handleRequest($request);

        $genre = $paginator->paginate(
            $repository->orderBy($order/* , $recherche */),
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('home/dashboardGenre.html.twig', [
            'nomTab' => 'des genres',
            'genres' => $genre,
            'genre' => '',
            // 'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/{action}-{id}', name: 'crud_dashboard')]
    public function itemDelete(Chanson $chanson, Request $request, EntityManagerInterface $entityManager, $action): Response
    {
        if($action == 'delete') {
            if($this->isCsrfTokenValid('delete' . $chanson->getId(), $request->get('_token'))) {
                $entityManager->remove($chanson);
                $entityManager->flush();
                return $this->redirectToRoute('show_dashboard');
            }
        } elseif($action == 'update') {
            $form = $this->createForm(ChansonType::class, $chanson);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                return $this->redirectToRoute('show_dashboard');
            }

            return $this->render('formulaire/chanson.html.twig', [
                'form' => $form->createView(),
            ]);
        }

    }

    #[Route('/dashboard/article/{id}', name: 'show_chanson')]
    public function article(EntityManagerInterface $entityManager, Chanson $chanson, Request $request, PaginatorInterface $paginator, $order = 'id'): Response
    {
        $repository = $entityManager->getRepository(Chanson::class);


        $recherche = new ChansonRecherche();
        $form = $this->createForm(ChansonRechercheType::class, $recherche);
        $form->handleRequest($request);

        $chansons = $paginator->paginate(
            $repository->orderBy($order, $recherche),
            $request->query->getInt('page', 1),
            3
        );

        $direction = $request->request->get('direction');
        if(isset($direction)) {
            if ($direction == 'up') {
                $chanson->increaseVotes();
            } elseif ($direction == 'down') {
                $chanson->decreaseVotes();
            }
            $entityManager->flush();
    
            return $this->redirectToRoute('show_chanson', [
                'id' => $chanson->getId(),
            ]);
        }

        return $this->render('home/dashboard.html.twig', [
            'nomTab' => 'des chansons',
            'chansons' => $chansons,
            'chanson' => $chanson,
            'form' => $form->createView(),
        ]);
    }
}
