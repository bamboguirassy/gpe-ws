<?php

namespace App\Form;

use App\Entity\InscriptionTemporaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionTemporaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idclasse')
            ->add('idspecialite')
            ->add('idregimeinscription')
            ->add('idmodaliteenseignement')
            ->add('idetudiant')
            ->add('idbourse')
            ->add('passage')
            ->add('idmodepaiement')
            ->add('montantinscriptionacad')
            ->add('coutformation')
            ->add('numquittance')
            ->add('source')
            ->add('croust')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InscriptionTemporaire::class,
        ]);
    }
}
