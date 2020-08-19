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
        $form_admin = $this->createForm(AdminType::class, $admin);

        // ref mande ny mandeha :D
        $form_admin->handleRequest($request);
        // refa soumis le entana
        if($form_admin->isSubmitted() && $form_admin->isValid()){
            // on hashe le password

            $hash = $enc->encodePassword($admin, $form->get('password')->getData());
            dd($admin);

        }
        return $this->render('security/register.html.twig', [
            "form_admin" =>$form_admin->createView()
        ]);
    }
}
