<?php

namespace App\Form;

use App\Entity\Inscriptionpedag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionpedagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateinscriptionpedag')
            ->add('passage')
            ->add('valide')
            ->add('moyenneobtenue')
            ->add('idanneeacad')
            ->add('idue')
            ->add('idetudiant')
            ->add('idinscriptionacad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscriptionpedag::class,
        ]);
    }
}
