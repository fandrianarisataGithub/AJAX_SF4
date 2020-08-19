<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Entity\Etudiant;
use App\Entity\Publication;
use App\Form\PublicationType;
use Doctrine\ORM\EntityManager;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/page/ajout_image", name="page.ajout.file")
     */
    public function ajout_image() 
    {   
        // creating form
        $pub = new Publication();
        $form_p = $this->createForm(PublicationType::class, $pub);

        return $this->render('page/ajout_image.html.twig',[
            "form_p" =>$form_p->createView()
        ]);
    }
     
    /**
     * @Route("/page/ajax_list", name="page.ajax.list")
     */
    public function do_ajax(Request $request, EntityManagerInterface $manager) 
    {   
        // alaina le requete
        
        if($request->isXmlHttpRequest()){
            
            $et = new Etudiant();
            if($request->get('matricule')){
                
               $et->setMatricule($request->get('matricule'));
                $et->setNom($request->get('nom'));
                $et->setPrenom($request->get('prenom'));
                $s = $request->get('dn');
                //$date = \DateTime::createFromFormat("Y-M-d" ,$s);
                //$external = "2020-06-25";
                $format = "Y-m-d";
                $dateobj = \DateTime::createFromFormat($format, $s);
                $et->setDateNaissance($dateobj);
                $et->setSexe($request->get('sexe'));
                $et->setClasse($request->get('classe'));

                $manager->persist($et);
                $manager->flush(); 

                // on récupère tous les etudiants
                $tab_et = $this->getDoctrine()
                ->getRepository(Etudiant::class)
                ->findAll();
                // on stock ces data dans u tableau 
                $tab = array();
                //var d incrementation pour lister les data
                $i = 0;
                foreach($tab_et as $t){
                    $tab[$i]['id'] = $t->getId();
                    $tab[$i]['matricule'] = $t->getMatricule();
                    $tab[$i]['nom'] = $t->getNom();
                    $tab[$i]['prenom'] = $t->getPrenom();
                    $tab[$i]['date_naissance'] = $t->getDateNaissance()->format('d-m-Y');;
                    $tab[$i]['sexe'] = $t->getSexe();
                    $tab[$i]['classe'] = $t->getClasse();

                    $i++;
                }

                $response = new Response();

                    $data = json_encode($tab); // formater le résultat de la requête en json

                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent($data);

                    return $response;
                
               //return new JsonResponse(array("data" => json_encode("ok")));
            }
            
        }
        $liste_et = $this->getDoctrine()
                            ->getRepository(Etudiant::class)
                            ->findAllEt();
        return $this->render('page/do_ajax.html.twig' , [
            "liste" =>$liste_et
        ]);
        
    }

   
}
