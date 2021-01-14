<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cni')
            ->add('ine')
            ->add('numinterne')
            ->add('nometudiant')
            ->add('prenometudiant')
            ->add('genre')
            ->add('datenaiss')
            ->add('lieunaiss')
            ->add('regionnaiss')
            ->add('adville')
            ->add('adquartier')
            ->add('adruevilla')
            ->add('email')
            ->add('emailUniv')
            ->add('notifmail')
            ->add('photo')
            ->add('lyceedeprovenance')
            ->add('teletudiant')
            ->add('teletudiant2')
            ->add('seriebac')
            ->add('diplomeentree')
            ->add('moyennebac')
            ->add('mentionbac')
            ->add('groupepassage')
            ->add('anneeBac')
            ->add('handicap')
            ->add('typeHandicap')
            ->add('descriptionHandicap')
            ->add('orphelin')
            ->add('situationMatrimoniale')
            ->add('nomconjoint')
            ->add('nbreenfant')
            ->add('nomcontact')
            ->add('telcontact')
            ->add('idpays')
            ->add('adpays')
            ->add('nationalite')
            ->add('typeOrphelin')
            ->add('typeHabitation')
            ->add('campusSocial')
            ->add('numeroChambre')
            ->add('quartierEtudiant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
