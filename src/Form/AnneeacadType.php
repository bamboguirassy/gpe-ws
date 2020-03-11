<?php

namespace App\Form;

use App\Entity\Anneeacad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnneeacadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeanneeacad')
            ->add('libelleanneeacad')
            ->add('encours')
            ->add('dateouvert')
            ->add('dateferm')
            ->add('nbreInscrits')
            ->add('anneesuivante')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Anneeacad::class,
        ]);
    }
}
