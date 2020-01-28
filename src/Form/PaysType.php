<?php

namespace App\Form;

use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('alpha2')
            ->add('alpha3')
            ->add('nomEnGb')
            ->add('nomFrFr')
            ->add('nationalite')
            ->add('montantInscriptionLicence')
            ->add('montantInscriptionMaster')
            ->add('montantInscriptionDoctorat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
