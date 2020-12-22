<?php

namespace App\Form;

use App\Entity\BourseEtudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BourseEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenoms')
            ->add('nom')
            ->add('dateNaissance')
            ->add('lieuNaissance')
            ->add('tauxBourse')
            ->add('montantBourse')
            ->add('mois')
            ->add('annee')
            ->add('cni')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BourseEtudiant::class,
        ]);
    }
}
