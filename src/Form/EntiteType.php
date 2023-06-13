<?php

namespace App\Form;

use App\Entity\Entite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idtypeentite')
            ->add('codenum')
            ->add('codeentite')
            ->add('libelleentite')
            ->add('statut')
            ->add('couleur')
            ->add('logo')
            ->add('email')
            ->add('telephone')
            ->add('siteweb')
            ->add('adresse')
            ->add('description')
            ->add('codeSigesr')
            ->add('paytechApiKey')
            ->add('paytechSecretKey')
            ->add('fraisTransaction')
            ->add('identiteparent')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entite::class,
        ]);
    }
}
