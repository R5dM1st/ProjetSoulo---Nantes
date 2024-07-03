<?php


/**
 * Le profile de la plongée défini la vitesse de descente, la vitesse de remontée et la respiration
 */
namespace PlongeeProfile;

/*
TABLE plongee_profile (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    vitesse_desc FLOAT,
    vitesse_asc FLOAT,
    respiration FLOAT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id)
);
*/


// Ajoute un profil à l'utilisateur
function addProfile($db,$nom, $vitesse_desc, $vitesse_asc, $respiration, $user_id)
{
    $query = 'INSERT INTO plongee_profile (nom,vitesse_desc, vitesse_asc, respiration, user_id) VALUES (:nom,:vitesse_desc, :vitesse_asc, :respiration, :user_id)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':vitesse_desc', $vitesse_desc);
    $stmt->bindParam(':vitesse_asc', $vitesse_asc);
    $stmt->bindParam(':respiration', $respiration);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $db->lastInsertId();
}

// Ajoute un profil qui n'appartient à personne
function addUnownedProfile($db,$nom, $vitesse_desc, $vitesse_asc, $respiration)
{
    $query = 'INSERT INTO plongee_profile (nom,vitesse_desc, vitesse_asc, respiration, user_id) VALUES (:nom,:vitesse_desc, :vitesse_asc, :respiration, NULL)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':vitesse_desc', $vitesse_desc);
    $stmt->bindParam(':vitesse_asc', $vitesse_asc);
    $stmt->bindParam(':respiration', $respiration);
    $stmt->execute();
    return $db->lastInsertId();
}


function getDefaultProfile($db){
    $query = 'SELECT * FROM plongee_profile WHERE user_id IS NULL LIMIT 1';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetch();
}

function getProfileById($db, $id)
{
    $query = 'SELECT * FROM plongee_profile WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

/**
 * Get the profile of the user and default profile
 */
function getProfileByUserId($db, $user_id)
{
    $query = 'SELECT * FROM plongee_profile WHERE user_id = :user_id OR user_id IS NULL';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUnownedProfiles($db)
{
    $query = 'SELECT * FROM plongee_profile WHERE user_id IS NULL';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function updateProfile($db, $id,$nom, $vitesse_desc, $vitesse_asc, $respiration, $user_id)
{
    $query = 'UPDATE plongee_profile SET vitesse_desc = :vitesse_desc, vitesse_asc = :vitesse_asc, respiration = :respiration, user_id = :user_id, nom = :nom WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':vitesse_desc', $vitesse_desc);
    $stmt->bindParam(':vitesse_asc', $vitesse_asc);
    $stmt->bindParam(':respiration', $respiration);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}


function deleteProfile($db, $id)
{
    $query = 'DELETE FROM plongee_profile WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
