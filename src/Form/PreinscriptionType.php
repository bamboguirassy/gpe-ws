<?php

namespace App\Form;

use App\Entity\Preinscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreinscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idfiliere')
            ->add('idanneeacad')
            ->add('idniveau')
            ->add('cni')
            ->add('idtypeadmission')
            ->add('ine')
            ->add('passage')
            ->add('prenometudiant')
            ->add('nometudiant')
            ->add('datenaiss')
            ->add('lieunaiss')
            ->add('email')
            ->add('tel')
            ->add('datenotif')
            ->add('datedelai')
            ->add('estinscrit')
            ->add('codeOperateur')
            ->add('datePaiement')
            ->add('numeroTransaction')
            ->add('montant')
            ->add('nationalite')
            ->add('idregimeinscription')
            ->add('paiementConfirme')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Preinscription::class,
        ]);
    }
}
