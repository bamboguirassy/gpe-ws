<?php

namespace App\Form;

use App\Entity\Inscriptionacad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionacadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateinscacad')
            ->add('passage')
            ->add('etat')
            ->add('montantinscriptionacad')
            ->add('coutformation')
            ->add('numquittance')
           /* ->add('cartetiree')
            ->add('certificattire')
            ->add('valide')
            ->add('quitusBu')
            ->add('quitusSocial')
            ->add('quitusMedical')
            ->add('quitusComptabilite')
            ->add('quitusVieUniversitaire')*/
            ->add('universitepartenaire')
            ->add('sourcefinancement')
            ->add('coencadreur')
            ->add('premiereanneeinscription')
            ->add('datemodification')
            ->add('moyenneAnnuelle')
            ->add('totalCredit')
            ->add('creditCapitalise')
            ->add('decisionConseil')
            ->add('idclasse')
            ->add('idmodaliteenseignement')
            ->add('idmodepaiement')
            ->add('idregimeinscription')
            ->add('idspecialite')
            ->add('idbourse')
            ->add('idetudiant')
            ->add('encadreur')
            ->add('idfosuser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscriptionacad::class,
        ]);
    }
}
