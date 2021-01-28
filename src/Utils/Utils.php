<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of Utils
 *
 * @author bambo
 */
class Utils {

    static $senderName = 'GPE';
    // static $senderEmail = 'support-spet@univ-thies.sn';
    static $senderEmail = 'admission@univ-thies.sn'; //'support-spet@univ-thies.sn';
    static $adminMail = 'moussa.fofana@univ-thies.sn';
//    static $lienValidationCompteEtudiant = 'http://localhost:4200/register/confirmation/';
    static $lienValidationCompteEtudiant = 'https://etudiant.univ-thies.sn//register/confirmation/';
//    static $lienResetEtudiantPassword = 'http://localhost:4200/resetpassword/';
    static $lienResetEtudiantPassword = 'https://etudiant.univ-thies.sn//resetpassword/';

    public static function serializeRequestContent(Request $request) {
        return json_decode($request->getContent(), true);
    }

    public static function getObjectFromRequest(Request $request) {
        return json_decode($request->getContent());
    }

    public static function getDateDifferenceInHours($date2, $date1) {
        // Formulate the Difference between two dates 
        $diff = abs($date2 - $date1);


// To get the year divide the resultant date into 
// total seconds in a year (365*60*60*24) 
        $years = floor($diff / (365 * 60 * 60 * 24));


// To get the month, subtract it with years and 
// divide the resultant date into 
// total seconds in a month (30*60*60*24) 
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));


// To get the day, subtract it with years and  
// months and divide the resultant date into 
// total seconds in a days (60*60*24) 
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


// To get the hour, subtract it with years,  
// months & seconds and divide the resultant 
// date into total seconds in a hours (60*60) 
       return $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
    }

}
