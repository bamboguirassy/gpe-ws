<?php

namespace App\Form;

use App\Entity\HistoriqueEtatReclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueEtatReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('userEmail')
            ->add('etat')
            ->add('reclamation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueEtatReclamation::class,
        ]);
    }
}
