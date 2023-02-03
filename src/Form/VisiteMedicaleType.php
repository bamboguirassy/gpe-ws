<?php

namespace App\Form;

use App\Entity\VisiteMedicale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteMedicaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('resultat')
            ->add('commentaire')
            ->add('inscriptionacad')
            ->add('maladieChroniques')
            ->add('typeHandicap')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VisiteMedicale::class,
        ]);
    }
}
