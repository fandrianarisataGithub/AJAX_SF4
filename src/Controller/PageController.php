<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Doctrine\ORM\EntityManager;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/page", name="page")
     */
    public function index()
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, EntityManagerInterface $manager)
    {   
        $l = new Lieu();
        $form = $this->createForm(LieuType::class, $l);
        //dd($request->request);
        $form->handleRequest($request);
        // si le form est soumis
        if($form->isSubmitted() && $form->isValid()){
            $l = $form->getData();
            //dd($l);   
            $manager->persist($l);
            //$manager->flush();
        }
        // on affiche tous les lieux
        $repo = $this->getDoctrine()->getRepository(Lieu::class);
        $liste = $repo->findAll();
        
        return $this->render('page/home.html.twig', [
            "form" => $form->createView(),
            "liste" => $liste
        ]);
    }

    /**
     * @Route("/page/ajax_lieu", name = "page.ajax.lieu")
     */
    public function ajout_lieu_ajax(Request $request,EntityManagerInterface $manager)
    {   
        // on traite les données du form2 ici
        if($request->isXmlHttpRequest()){
            $nom = $request->get('nom');
            $climat = $request->get('climat');
            //$data = $nom .' / ' .$climat;  
            if(!empty($nom) && !empty($climat)){
                $lieu = new Lieu();
                $lieu->setNom($nom);
                $lieu->setClimat($climat);
                $manager->persist($lieu);
                $manager->flush();
                return new JsonResponse(array("data" => json_encode("ok")));
            }
            else {
                return new JsonResponse(array("data" => json_encode("nisy vide")));
            }
           
        }
        
        return $this->render('page/home.html.twig');

    }
}
