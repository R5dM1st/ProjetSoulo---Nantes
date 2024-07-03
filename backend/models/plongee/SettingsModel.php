<?php

/**
 * Les settings de la plongée définissent la profondeur et la durée de la plongée
 */
namespace PlongeeSettings;


/*
TABLE plongee_settings (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    profondeur FLOAT,
    duree INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id)
);
*/


// Ajoute une plongée à l'utilisateur
function addPlongeeSettings($db,$nom, $profondeur, $duree, $user_id)
{
    $query = 'INSERT INTO plongee_settings (nom,profondeur, duree, user_id) VALUES (:nom,:profondeur, :duree, :user_id)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':profondeur', $profondeur);
    $stmt->bindParam(':duree', $duree);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $db->lastInsertId();
}

// Ajoute une plongée qui n'appartient à personne
function addUnownedPlongeeSettings($db, $profondeur, $duree)
{
    $query = 'INSERT INTO plongee_settings (profondeur, duree, user_id) VALUES (:profondeur, :duree, NULL)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':profondeur', $profondeur);
    $stmt->bindParam(':duree', $duree);
    $stmt->execute();
    return $db->lastInsertId();
}


function getPlongeeSettingsById($db, $id)
{
    $query = 'SELECT * FROM plongee_settings WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getPlongeeSettingsByUserId($db, $user_id)
{
    $query = 'SELECT * FROM plongee_settings WHERE user_id = :user_id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUnownedPlongeeSettings($db)
{
    $query = 'SELECT * FROM plongee_settings WHERE user_id IS NULL';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function updatePlongeeSettings($db, $id, $profondeur, $duree)
{
    $query = 'UPDATE plongee_settings SET profondeur = :profondeur, duree = :duree WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':profondeur', $profondeur);
    $stmt->bindParam(':duree', $duree);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deletePlongeeSettings($db, $id)
{
    $query = 'DELETE FROM plongee_settings WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}



