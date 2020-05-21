<?php

namespace App\Form;

use App\Entity\HistoriqueEtatDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueEtatDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('userMail')
            ->add('demande')
            ->add('etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueEtatDemande::class,
        ]);
    }
}
