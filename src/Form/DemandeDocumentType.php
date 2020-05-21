<?php

namespace App\Form;

use App\Entity\DemandeDocument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('intitule')
            ->add('etatActuel')
            ->add('inscriptionacad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeDocument::class,
        ]);
    }
}
