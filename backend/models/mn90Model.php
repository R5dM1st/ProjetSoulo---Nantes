<?php


namespace Mn90;


function getTable($db)
{
    $query = 'SELECT * FROM mn90';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}


function getRow($db,$profondeur,$duree){
    $query = 'SELECT * FROM mn90 WHERE prof = :profondeur AND t >= :duree ORDER BY t ASC LIMIT 1';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':profondeur', $profondeur);
    $stmt->bindParam(':duree', $duree);
    $stmt->execute();
    return $stmt->fetch();
}