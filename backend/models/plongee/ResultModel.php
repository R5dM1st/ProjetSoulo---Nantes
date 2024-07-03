<?php


namespace PlongeeResult;

/*
return:
    [
        {
            line : 0,
            profondeur: 10,
            temps: 20,
            pression_ambiante:
            consomation: 20,
            bar_restant: X
            volume: X
        }
        ....
    ]
*/

/*
$plongee =
{
    "id":7,
    "nom":"hoouhugyhgiooiuh",
    "date":"2024-06-27",
    "private":true,
    "user_id":1,
    "plongee_profile_id":1,
    "plongee_settings_id":8,
    "equipement_id":1,
    "profile_nom":"Profil par d\u00e9faut",
    "vitesse_desc":"20",
    "vitesse_asc":"10",
    "respiration":"20",
    "settings_nom":"hoouhugyhgiooiuh - settings",
    "profondeur":"6",
    "duree":28,
    "equipement_nom":"Bouteille par d\u00e9faut",
    "contenance":20,
    "pression":200
}



$mntablerow = 
{
    prof, t, m15, m12, m9, m6, m3, dtr, gps
}



$plongee =
{
    "id":7,
    "nom":"hoouhugyhgiooiuh",
    "date":"2024-06-27",
    "private":true,
    "user_id":1,
    "plongee_profile_id":1,
    "plongee_settings_id":8,
    "equipement_id":1,
    "profile_nom":"Profil par d\u00e9faut",
    "vitesse_desc": 20,
    "vitesse_asc": 10,
    "respiration": 20,
    "settings_nom":"hoouhugyhgiooiuh - settings",
    "profondeur":25,
    "duree":35,
    "equipement_nom":"Bouteille par d\u00e9faut",
    "contenance":20,
    "pression":200

};


$mntablerow = [25, 35, NULL, NULL, NULL, NULL, 5, 2, "A"];
*/

function getTableau($plongee, $mntablerow, $ligne){

    $respiration = $plongee["respiration"];
    $duree = $plongee["duree"];
    $profondeur = $plongee["profondeur"];
    $vit_desc = $plongee["vitesse_desc"];
    $vit_asc = $plongee["vitesse_asc"];
    $bar_init = $plongee["pression"];
    $vol_init = $plongee["contenance"]*$bar_init;

    $pallile = 0 ;
    $lenght = 3 ;

    if($mntablerow[2] != null){
        $pallile = 5;
        $lenght = ( $pallile * 2 ) + 3;
    }
    if($mntablerow[3] != null){
        $pallile = 4;
        $lenght = ( $pallile * 2 ) + 3;
    }
    if($mntablerow[4] != null){
        $pallile = 3;
        $lenght = ( $pallile * 2 ) + 3;
    }
    if($mntablerow[5] != null){
        $pallile = 2;
        $lenght = ( $pallile * 2 ) + 3;
    }
    if($mntablerow[6] != null){
        $pallile = 1;
        $lenght = ( $pallile * 2 ) + 3;
    }

    $tt = array();

    for($i = 0; $i <= $lenght; $i++){
        
        switch($i){
            case 0:
                $tt = array_push([0, 0, 1, 0, $bar_init, $vol_init]);
                break;
            case 1:
                $tt = array_push([$profondeur, calTime($profondeur, $vit_desc), calPression($profondeur/2), 0, 0, 0]);
                break;
            case 2:
                $tt = array_push([$profondeur, $duree, calPression($profondeur), 0, 0, 0]);
                break;
            default:
                $tt = array_push([0, 0, 0, 0, 0, 0]);
                break;
        }

    }

    switch ($pallile){

        case 0:
            $tt[3][0] = 0;
            $tt[3][1] = calTime($profondeur, $vit_asc);
            $tt[3][2] = 1;
            break;
        case 1:
            $tt[3][0] = 3;
            $tt[3][1] = calTime($profondeur-3, $vit_asc);
            $tt[3][2] = calPression(($profondeur+3)/2);

            $tt[4][0] = 3;
            $tt[4][1] = $mntablerow[6];
            $tt[4][2] = calPression(3);

            $tt[5][0] = 0;
            $tt[5][1] = calTime(3, $vit_asc);
            $tt[5][2] = 1;
            break;

        case 2:
            $tt[3][0] = 6;
            $tt[3][1] = calTime($profondeur-6, $vit_asc);
            $tt[3][2] = calPression(($profondeur+6)/2);

            $tt[4][0] = 6;
            $tt[4][1] = $mntablerow[5];
            $tt[4][2] = calPression(6);

            $tt[5][0] = 3;
            $tt[5][1] = calTime(6-3, $vit_asc);
            $tt[5][2] = calPression((6+3)/2);

            $tt[6][0] = 3;
            $tt[6][1] = $mntablerow[6];
            $tt[6][2] = calPression(3);

            $tt[7][0] = 0;
            $tt[7][1] = calTime(3, $vit_asc);
            $tt[7][2] = 1;
            break;

        case 3:
            $tt[3][0] = 9;
            $tt[3][1] = calTime($profondeur-9, $vit_asc);
            $tt[3][2] = calPression(($profondeur+9)/2);

            $tt[4][0] = 9;
            $tt[4][1] = $mntablerow[4];
            $tt[4][2] = calPression(9);

            $tt[5][0] = 6;
            $tt[5][1] = calTime(9-6, $vit_asc);
            $tt[5][2] = calPression((9+6)/2);

            $tt[6][0] = 6;
            $tt[6][1] = $mntablerow[5];
            $tt[6][2] = calPression(6);

            $tt[7][0] = 3;
            $tt[7][1] = calTime(6-3, $vit_asc);
            $tt[7][2] = calPression((6+3)/2);

            $tt[8][0] = 3;
            $tt[8][1] = $mntablerow[6];
            $tt[8][2] = calPression(3);

            $tt[9][0] = 0;
            $tt[9][1] = calTime(3, $vit_asc);
            $tt[9][2] = 1;
            break;

        case 4:
            $tt[3][0] = 12;
            $tt[3][1] = calTime($profondeur-12, $vit_asc);
            $tt[3][2] = calPression(($profondeur+12)/2);

            $tt[4][0] = 12;
            $tt[4][1] = $mntablerow[3];
            $tt[4][2] = calPression(12);

            $tt[3][0] = 9;
            $tt[3][1] = calTime(12-9, $vit_asc);
            $tt[3][2] = calPression((12+9)/2);

            $tt[4][0] = 9;
            $tt[4][1] = $mntablerow[4];
            $tt[4][2] = calPression(9);

            $tt[5][0] = 6;
            $tt[5][1] = calTime(9-6, $vit_asc);
            $tt[5][2] = calPression((9+6)/2);

            $tt[6][0] = 6;
            $tt[6][1] = $mntablerow[5];
            $tt[6][2] = calPression(6);

            $tt[7][0] = 3;
            $tt[7][1] = calTime(6-3, $vit_asc);
            $tt[7][2] = calPression((6+3)/2);

            $tt[8][0] = 3;
            $tt[8][1] = $mntablerow[6];
            $tt[8][2] = calPression(3);

            $tt[9][0] = 0;
            $tt[9][1] = calTime(3, $vit_asc);
            $tt[9][2] = 1;
            break;

        case 5:
            $tt[3][0] = 15;
            $tt[3][1] = calTime($profondeur-15, $vit_asc);
            $tt[3][2] = calPression(($profondeur+15)/2);

            $tt[4][0] = 15;
            $tt[4][1] = $mntablerow[2];
            $tt[4][2] = calPression(15);

            $tt[5][0] = 12;
            $tt[5][1] = calTime(15-12, $vit_asc);
            $tt[5][2] = calPression((15+12)/2);

            $tt[6][0] = 12;
            $tt[6][1] = $mntablerow[3];
            $tt[6][2] = calPression(12);

            $tt[7][0] = 9;
            $tt[7][1] = calTime(12-9, $vit_asc);
            $tt[7][2] = calPression((12+9)/2);

            $tt[8][0] = 9;
            $tt[8][1] = $mntablerow[4];
            $tt[8][2] = calPression(9);

            $tt[9][0] = 6;
            $tt[9][1] = calTime(9-6, $vit_asc);
            $tt[9][2] = calPression((9+6)/2);

            $tt[10][0] = 6;
            $tt[10][1] = $mntablerow[5];
            $tt[10][2] = calPression(6);

            $tt[11][0] = 3;
            $tt[11][1] = calTime(6-3, $vit_asc);
            $tt[11][2] = calPression((6+3)/2);

            $tt[12][0] = 3;
            $tt[12][1] = $mntablerow[6];
            $tt[12][2] = calPression(3);

            $tt[13][0] = 0;
            $tt[13][1] = calTime(3, $vit_asc);
            $tt[13][2] = 1;
            break;
    }

    for($i = 1; $i <= $lenght; $i ++){

        $tt[$i][3] = calConso($respiration, $tt[$i][1], $tt[$i][2]);
        $tt[$i][5] = calVolRest($tt[$i-1][5], $tt[$i][3]);
        $tt[$i][4] = calBarRest($tt[$i][5], $vol_init, $bar_init);

    }
    
    return $tt;
}

function calVolRest($vol_av, $conso){
    return $vol_av - $conso;
}

function calBarRest($vol_rest, $vol_init, $bar_init){
    return ( $vol_rest * $bar_init ) / $vol_init ;
}

function calConso($a, $b, $c){
    return $a*$b*$c ;
}

function calPression($prof){
    return ($prof/10)+1;
}

function calTime($distance, $vitesse){
    return $distance/$vitesse;
}

/*function getPlongeeResult($db, $plongee, $mntablerow)
{
    //la pression augment de 1 bar tout les 10m
    $t = array(array(
        'profondeur' => 0,
        'temps' => 0,
        'pression_ambiante' => 1,
        'consomation' => 0,
        'bar_restant' => $plongee["pression"],
        'volume' => $mntablerow['contenance']
    ));

    $tmp = $plongee["profondeur"] / $plongee["vitesse_desc"];
    $pression = 1 + $plongee["profondeur"] / 10;
    $consommation = $plongee["respiration"] * $t[0]["temps"] - $tmp;
    $br = $t[0]["bar_restant"] - $consommation;

    
}*/
