<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security/inscription", name="security.inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $enc )
    {   
        $admin = new Admin();
        $formAdmin= $this->createForm(AdminType::class, $admin, array('method' => 'PUT'));
        $formAdmin->handleRequest($request);
        //dd($request);
        
        return $this->render('security/register.html.twig', [        
            "form_admin" =>$formAdmin->createView(),
            "pass" =>"tsy mbola nisy"
        ]);
    }
}
