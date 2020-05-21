<?php

namespace App\Form;

use App\Entity\ReclamationBourse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationBourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('objet')
            ->add('message')
            ->add('bourseEtudiant')
            ->add('etatActuel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReclamationBourse::class,
        ]);
    }
}
