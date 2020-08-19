<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class, [
                "attr" => [
                    "placeholder" =>"Titre de la publication",
                    "class" =>"form-control"
                ]
            ])
            ->add('contenu', TextareaType::class, [
                "attr" => [
                    "placeholder" =>"Contenu de la publication",
                    "class" =>"form-control"
                ]
            ])
            ->add('image', FileType::class)
            ->add("Enregistrer", SubmitType::class,[
                "attr" => [
                    "value" =>"Enregistrer",
                    "class" =>"form-control btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
