<?php

namespace resultTable;

function getTableau($plongee, $mntablerow)
{
    $result = []; //result de la descente
    $profondeur = $plongee["profondeur"];
    $duree = $plongee["duree"];
    $pression = $plongee["pression"];
    $contenance = $plongee["contenance"] * $pression;
    $vitesse_desc = $plongee["vitesse_desc"];
    $vitesse_asc = $plongee["vitesse_asc"];
    $respiration = $plongee["respiration"];

    //get the first palier
    $palier =
        $mntablerow["m15"] != null
            ? 15
            : ($mntablerow["m12"] != null
                ? 12
                : ($mntablerow["m9"] != null
                    ? 9
                    : ($mntablerow["m6"] != null
                        ? 6
                        : ($mntablerow["m3"] != null
                            ? 3
                            : 0))));

    $bar_restant = $pression;
    $volume_restant = $contenance;

    // t0
    $result[] = [
        "profondeur" => 0,
        "temps" => 0,
        "pression_ambiante" => 1,
        "consommation" => 0,
        "bar_restant" => $bar_restant,
        "volume" => $volume_restant,
    ];

    $pression_ambiante = 1 + $profondeur / 2 / 10;
    $temps = $profondeur / $vitesse_desc; //temps entre t0 et t1
    $consommation = $temps * $respiration * $pression_ambiante; //consmation entre t0 et t1
    $volume_restant = $volume_restant - $consommation;
    $bar_restant = calBarRest(
        $volume_restant,
        $contenance,
        $plongee["pression"]
    );

    // t1
    $result[] = [
        "profondeur" => $profondeur,
        "temps" => $temps,
        "pression_ambiante" => $pression_ambiante,
        "consommation" => $consommation,
        "bar_restant" => $bar_restant,
        "volume" => $volume_restant,
    ];

    $pression_ambiante = 1 + $profondeur / 10;
    $temps = $duree - $temps; //temps entre t1 et t2
    $consommation = $temps * $respiration * $pression_ambiante; //consmation entre t1 et t2
    $volume_restant = $volume_restant - $consommation;
    $bar_restant = calBarRest(
        $volume_restant,
        $contenance,
        $plongee["pression"]
    );

    // t2
    $result[] = [
        "profondeur" => $profondeur,
        "temps" => $temps,
        "pression_ambiante" => $pression_ambiante,
        "consommation" => $consommation,
        "bar_restant" => $bar_restant,
        "volume" => $volume_restant,
    ];

    while ($mntablerow["m" . $palier] != null) {
        //temps entre $profondeur et $palier
        $pression_ambiante = 1 + $palier / 10;
        $temps = ($profondeur - $palier) / $vitesse_asc;
        $consommation = $temps * $respiration * $pression_ambiante;
        $volume_restant = $volume_restant - $consommation;
        $bar_restant = calBarRest(
            $volume_restant,
            $contenance,
            $plongee["pression"]
        );
        $profondeur = $palier;

        $result[] = [
            "profondeur" => $palier,
            "temps" => $temps,
            "pression_ambiante" => $pression_ambiante,
            "consommation" => $consommation,
            "bar_restant" => $bar_restant,
            "volume" => $volume_restant,
        ];
        $pression_ambiante = 1 + $palier / 10;
        $temps = $mntablerow["m" . $palier] - $temps; //temps entre $palier et $palier+1
        $consommation = $temps * $respiration * $pression_ambiante;
        $volume_restant = $volume_restant - $consommation;
        $bar_restant = calBarRest(
            $volume_restant,
            $contenance,
            $plongee["pression"]
        );

        $result[] = [
            "profondeur" => $palier,
            "temps" => $temps,
            "pression_ambiante" => $pression_ambiante,
            "consommation" => $consommation,
            "bar_restant" => $bar_restant,
            "volume" => $volume_restant,
        ];

        $palier = $palier - 3;
        if ($palier <= 0) {
            break;
        }
    }

    //temps entre $palier et 0
    $temps = $palier / $vitesse_asc;
    $consommation = $temps * $respiration;
    $volume_restant = $volume_restant - $consommation;
    $bar_restant = calBarRest(
        $volume_restant,
        $contenance,
        $plongee["pression"]
    );

    $result[] = [
        "profondeur" => 0,
        "temps" => $temps,
        "pression_ambiante" => 1,
        "consommation" => $consommation,
        "bar_restant" => $bar_restant,
        "volume" => $volume_restant,
    ];
    return $result;
}

function calBarRest($vol_rest, $vol_init, $pression)
{
    return ($vol_rest / $vol_init) * $pression;
}
