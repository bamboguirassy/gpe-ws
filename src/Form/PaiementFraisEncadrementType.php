<?php

namespace App\Form;

use App\Entity\PaiementFraisEncadrement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementFraisEncadrementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePaiement')
            ->add('montantPaye')
            ->add('filename')
            ->add('url')
            ->add('methodePaiement')
            ->add('inscriptionacad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaiementFraisEncadrement::class,
        ]);
    }
}
