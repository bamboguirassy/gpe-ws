<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Ldap;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Ldap\Ldap;
use App\Entity\Etudiant;
use Symfony\Component\Ldap\Entry;

/**
 * Description of LdapManager
 *
 * @author bambo
 */
class LdapManager extends Controller {

    private static $ldapManager;
    private static $ldap;
    private static $racine = 'dc=univ-thies,dc=sn';
    private static $rootdn = 'cn=admin,dc=univ-thies,dc=sn';
    private static $rootpw = 'passer';
    private static $entryManager;

    private function __construct() {
        
    }

    /**
     * 
     * @return LdapManager
     */
    public static function getInstance() {
        if (!LdapManager::$ldapManager) {
            LdapManager::$ldapManager = new LdapManager();
            LdapManager::$ldap = Ldap::create('ext_ldap', array('connection_string' => '10.157.10.212'));
            LdapManager::$ldap->bind(LdapManager::$rootdn, LdapManager::$rootpw);
            LdapManager::$entryManager = LdapManager::$ldap->getEntryManager();
        }
        return LdapManager::$ldapManager;
    }

    public function addEtudiant(Etudiant $etudiant, Controller $controller) {
        //reccuperer la dernier inscriptionacademique de l'étudiant

        $em = $controller->getDoctrine()->getManager();
        //find latest inscriptionacad
        $inscriptionacads = $em->createQuery("select ia from LmdproBundle:Inscriptionacad ia "
                        . "where ia.idetudiant=?1 order by ia.id desc")
                ->setParameter(1, $etudiant)
                ->getResult();
        if (count($inscriptionacads) < 1) {
            throw new \Exception($etudiant->getNuminterne() . " n'a aucune inscription administrative dans l'université");
        }

        $inscriptionacad = $inscriptionacads[0];

        $info["objectClass"][0] = "inetOrgPerson";
        $info["objectClass"][1] = "top";
        $info["objectClass"][2] = "supannPerson";
        $info["objectClass"][3] = "schacPersonalCharacteristics";
        $info["objectClass"][4] = "shadowAccount";
        $mail = LdapManager::genererUniqueEmail($etudiant);
        $genre = 0;
        if ($etudiant->getGenre() == 'M') {
            $genre = 1;
        } else {
            $genre = 2;
        }
        $info["cn"] = LdapManager::suppr_accents("" . $etudiant->getPrenometudiant() . " " . $etudiant->getNometudiant() . "");
        $info["sn"] = LdapManager::suppr_accents("" . $etudiant->getPrenometudiant() . " " . $etudiant->getNometudiant() . "");
        $ine = $etudiant->getIne();
        if ($ine && ($ine = '-' || $ine = '/')) {
            $ine = '';
        }
        $info["supannCodeINE"] = LdapManager::suppr_accents("" . $ine . "");
        $info["supannEtuId"] = "" . $etudiant->getNuminterne() . "";
        $info["supannMailPerso"] = "" . $etudiant->getEmail() . "";
        $info["supannEtuTypeDiplome"] = $inscriptionacad->getIdspecialite()->getIdtypediplome()->getCodetypediplome();
        $info["supannEtuCursusAnnee"] = $inscriptionacad->getIdclasse()->getIdniveau()->getLibelleniveau();
        $info["supannEtuSecteurDisciplinaire"] = $inscriptionacad->getIdclasse()->getIdfiliere()->getCodefiliere();
        $info["givenName"] = LdapManager::suppr_accents("" . $etudiant->getNometudiant() . "");
        $info["userPassword"] = "" . $etudiant->getNuminterne() . "";
        $info["schacPlaceOfBirth"] = LdapManager::suppr_accents("" . $etudiant->getLieunaiss() . "");
        if ($etudiant->getDatenaiss()) {
            $info["schacDateOfBirth"] = "" . $etudiant->getDatenaiss()->format('dmY') . "";
        }
        $info["schacGender"] = "" . $genre . "";
        $info["telephoneNumber"] = $etudiant->getTeletudiant();
        $info["displayName"] = $etudiant->getPrenometudiant() . ' ' . $etudiant->getNometudiant();
        if ($inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite()->getIdentiteparent()) {
            $etablissement = $inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite()->getIdentiteparent();
        } else {
            $etablissement = $inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite();
        }
        $info["organizationName"] = $etablissement->getCodeentite();
        $info["organizationalUnitName"] = $inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite()->getCodeentite();
        $info["mail"] = "" . $mail . "";
        foreach ($info as $key => $value) {
            if ($value == null) {
                $info[$key] = 'non defini';
            }
        }
        $people = "uid=" . $mail . ",ou=people,dc=univ-thies,dc=sn";
        $entry = new Entry($people, $info);
        // Creating a new entry
        LdapManager::$entryManager->add($entry);
        return $mail;
    }

    public function addPrimoEntrant(Etudiant $etudiant, \App\Entity\Preinscription $preinscription, $controller) {

        $info["objectClass"][0] = "inetOrgPerson";
        $info["objectClass"][1] = "top";
        $info["objectClass"][2] = "supannPerson";
        $info["objectClass"][3] = "schacPersonalCharacteristics";
        $info["objectClass"][4] = "shadowAccount";
        $mail = LdapManager::genererUniqueEmail($etudiant);
        $genre = 0;
        if ($etudiant->getGenre() == 'M') {
            $genre = 1;
        } else {
            $genre = 2;
        }
        $info["cn"] = LdapManager::suppr_accents("" . $etudiant->getPrenometudiant() . " " . $etudiant->getNometudiant() . "");
        $info["sn"] = LdapManager::suppr_accents("" . $etudiant->getPrenometudiant() . " " . $etudiant->getNometudiant() . "");
        $ine = $etudiant->getIne();
        if ($ine && ($ine = '-' || $ine = '/')) {
            $ine = '';
        }
        $info["supannCodeINE"] = LdapManager::suppr_accents("" . $ine . "");
        $info["supannEtuId"] = "" . $etudiant->getNuminterne() . "";
        $info["supannMailPerso"] = "" . $etudiant->getEmail() . "";
//        $info["supannEtuTypeDiplome"] = $inscriptionacad->getIdspecialite()->getIdtypediplome()->getCodetypediplome();
        $info["supannEtuCursusAnnee"] = $preinscription->getIdniveau()->getLibelleniveau();
        $info["supannEtuSecteurDisciplinaire"] = $preinscription->getIdfiliere()->getCodefiliere();
        $info["givenName"] = LdapManager::suppr_accents("" . $etudiant->getNometudiant() . "");
        $info["userPassword"] = "" . $etudiant->getNuminterne() . "";
        $info["schacPlaceOfBirth"] = LdapManager::suppr_accents("" . $etudiant->getLieunaiss() . "");
        $info["schacDateOfBirth"] = "" . $etudiant->getDatenaiss()->format('dmY') . "";
        $info["schacGender"] = "" . $genre . "";
        $info["telephoneNumber"] = $etudiant->getTeletudiant();
        $info["displayName"] = $etudiant->getPrenometudiant() . ' ' . $etudiant->getNometudiant();
        if ($preinscription->getIdfiliere()->getIdentite()->getIdentiteparent()) {
            $etablissement = $preinscription->getIdfiliere()->getIdentite()->getIdentiteparent();
        } else {
            $etablissement = $preinscription->getIdfiliere()->getIdentite();
        }
        $info["organizationName"] = $etablissement->getCodeentite();
        $info["organizationalUnitName"] = $preinscription->getIdfiliere()->getIdentite()->getCodeentite();
        $info["mail"] = "" . $mail . "";
        foreach ($info as $key => $value) {
            if ($value == null) {
                $info[$key] = 'non defini';
            }
        }
        $people = "uid=" . $mail . ",ou=people,dc=univ-thies,dc=sn";
        $entry = new Entry($people, $info);
        // Creating a new entry
       // LdapManager::$entryManager->add($entry);
        return $mail;
    }

    public function updateInLdap(Etudiant $etudiant, Controller $controller) {
        $query = LdapManager::$ldap->query(LdapManager::$racine, "(supannetuid=" . LdapManager::suppr_accents($etudiant->getNuminterne()) . ")");
//        $query = LdapManager::$ldap->query(LdapManager::$racine, "(mail=".$etudiant->getEmailUniv().")");
        $results = $query->execute();
        $em = $controller->getDoctrine()->getManager();
        $inscriptionacads = $em->createQuery("select ia from LmdproBundle:Inscriptionacad ia "
                        . "where ia.idetudiant=?1 order by ia.id desc")
                ->setParameter(1, $etudiant)
                ->getResult();
        if (count($inscriptionacads) < 1) {
            throw new \Exception($etudiant->getNuminterne() . " n'a aucune inscription administrative dans l'université");
        }

        $inscriptionacad = $inscriptionacads[0];
        if ($inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite()->getIdentiteparent()) {
            $etablissement = $inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite()->getIdentiteparent();
        } else {
            $etablissement = $inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite();
        }
        if (count($results)) {
            $entry = $results[0];
            if (count($entry->getAttribute('mail'))) {
                $etudiant->setEmailUniv($entry->getAttribute('mail')[0]);
                //
            }
            //update entries attributes
            $entry->setAttribute('supannEtuTypeDiplome', array(LdapManager::suppr_accents($inscriptionacad->getIdspecialite()->getIdtypediplome()->getCodetypediplome())));
            $entry->setAttribute('supannEtuCursusAnnee', array(LdapManager::suppr_accents($inscriptionacad->getIdclasse()->getIdniveau()->getLibelleniveau())));
            $entry->setAttribute('supannEtuSecteurDisciplinaire', array(LdapManager::suppr_accents($inscriptionacad->getIdclasse()->getIdfiliere()->getCodefiliere())));
            //find telephone
            $telephone = ($etudiant->getTeletudiant() != null) ? LdapManager::suppr_accents($etudiant->getTeletudiant()) : 'non defini';
            $entry->setAttribute('telephoneNumber', array($telephone));
            $entry->setAttribute('displayName', array(LdapManager::suppr_accents($etudiant->getPrenometudiant() . ' ' . $etudiant->getNometudiant())));
            $entry->setAttribute('organizationName', array(LdapManager::suppr_accents($etablissement->getCodeentite())));
            $entry->setAttribute('organizationalUnitName', array(LdapManager::suppr_accents($inscriptionacad->getIdclasse()->getIdfiliere()->getIdentite()->getCodeentite())));
            LdapManager::$entryManager->update($entry);
        }
    }

    public function checkIfEmailExistsInLdap($mail) {
        $query = LdapManager::$ldap->query(LdapManager::$racine, "(mail=" . $mail . ")");
//        $query = LdapManager::$ldap->query(LdapManager::$racine, "(mail=".$etudiant->getEmailUniv().")");
        $results = $query->execute();
        if (count($results)) {
            return true;
        }
        return false;
    }

    public function checkIfEtudiantHasEmailInLdap(Etudiant $etudiant) {
        $query = LdapManager::$ldap->query(LdapManager::$racine, "(supannetuid=" . LdapManager::suppr_accents($etudiant->getNuminterne()) . ")");
//        $query = LdapManager::$ldap->query(LdapManager::$racine, "(mail=".$etudiant->getEmailUniv().")");
        $results = $query->execute();
        if (count($results)) {
            $entry = $results[0];
            if (count($entry->getAttribute('mail'))) {
                return $entry->getAttribute('mail')[0];
            }
        }
        return null;
    }

    public static function suppr_accents($str, $encoding = 'utf-8') {
// transformer les caractères accentués en entités HTML
        $htmlentities = htmlentities($str, ENT_NOQUOTES, $encoding);
// remplacer les entités HTML pour avoir juste le premier caractères non accentués
// Exemple : "&ecute;" => "e", "&Ecute;" => "E", "à" => "a" ...
        $preg_replace = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $htmlentities);
// Remplacer les ligatures tel que : , Æ ...
// Exemple "œ" => "oe"
        $preg_replace2 = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $preg_replace);
// Supprimer tout le reste
        $final_string = preg_replace('#&[^;]+;#', '', $preg_replace2);

        return $final_string;
    }

    public function removeFromLdap(Etudiant $etudiant) {
        // Removing an existing entry
        LdapManager::$entryManager->remove(new Entry('cn=Test User,dc=symfony,dc=com'));
    }

    public static function genererUniqueEmail(Etudiant $etudiant) {
        $prenom = LdapManager::suppr_accents($etudiant->getPrenometudiant());
        $nom = LdapManager::suppr_accents($etudiant->getNometudiant());
        $tabPrenom = explode(' ', $prenom);
        $newPrenom = '';
        if (count($tabPrenom) > 0) {
            $longueur = count($tabPrenom) - 1;
            for ($i = 0; $i < $longueur; $i++) {
                $newPrenom = $newPrenom . '' . substr($tabPrenom[$i], 0, 1);
            }

            $newPrenom = $newPrenom . '' . $tabPrenom[$longueur];
        }

        $tabNom = explode(' ', $nom);
        $newNom = '';
        if (count($tabNom) > 0) {
            $longueur = count($tabNom) - 1;
            for ($i = 0; $i < $longueur; $i++) {
                $newNom = $newNom . '' . substr($tabNom[$i], 0, 1);
            }

            $newNom = $newNom . '' . $tabNom[$longueur];
        }

        $email = str_replace(' ', '', strtolower($newPrenom . "." . $newNom . "@univ-thies.sn"));
        $email = str_replace("'", "", $email);
        //verifier s'il y'a un étudiant avec cet email
        if (!LdapManager::getInstance()->checkIfEmailExistsInLdap($email)) {
//mail n'esist pas
            return $email;
        } else {
//mail exist
            $i = 1;
            while (LdapManager::getInstance()->checkIfEmailExistsInLdap($email)) {
                $email = str_replace(' ', '', strtolower($newPrenom . "." . $newNom . "" . $i . "@univ-thies.sn"));
                $email = str_replace("'", "", $email);
                //verifier si l'email existe dans ldap
                if (!LdapManager::getInstance()->checkIfEmailExistsInLdap($email)) {
                    return $email;
                }

                $i = $i + 1;
            }
        }
    }

}
