<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                "attr" => [
                    "placeholder" => "Votre adresse email",
                    "class" => "form-control",
                ]
            ])
            ->add('password', PasswordType::class, [
                "attr" => [
                    "placeholder" => "Votre mot de passe",
                    "class" => "form-control",
                ]
            ])
            ->add('c_password', PasswordType::class, [
                "attr" => [
                    "placeholder" => "Confirmer le mot de passe",
                    "class" => "form-control",
                ]
            ])
            ->add('type_admin', ChoiceType::class,[
                "choices" => [
                    "Administrateur" =>"administrateur",
                    "Super Administrateur" =>"super administrateur"
                ],
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('insert', SubmitType::class, [
                "attr" => [
                    "value" => "Ajouter",
                    "class" => "form-control btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
