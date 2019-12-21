<?php

namespace App\Form;

use App\Entity\FosUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FosUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('prenom')
            ->add('nom')
            ->add('sexe')
            ->add('titre')
            ->add('photo')
            ->add('statut')
            ->add('last_activity')
            ->add('profession')
            ->add('groups')
            ->add('idgroup')
            ->add('entiteprincipale')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FosUser::class,
        ]);
    }
}
