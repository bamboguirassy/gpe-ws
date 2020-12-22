<?php

namespace App\Form;

use App\Entity\AssistanceEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssistanceEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeAssistance')
            ->add('email')
            ->add('etat')
            ->add('destinationApp')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AssistanceEmail::class,
        ]);
    }
}
