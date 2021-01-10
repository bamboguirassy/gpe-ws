<?php

namespace App\Form;

use App\Entity\DocumentEtudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filename')
            ->add('url')
            ->add('dateAjout')
            ->add('titreDocument')
            ->add('estValide')
            ->add('dateValidation')
            ->add('userValidation')
            ->add('etudiant')
            ->add('typeDocument')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DocumentEtudiant::class,
        ]);
    }
}
