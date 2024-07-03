<?php

/**
 * L'équipement désigne la bouteille utilisée pour la plongée
 */
namespace Equipement;

/*
TABLE equipement (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    contenance INT,
    pression INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id)
);*/


// Ajoute un equipement à l'utilisateur
function addOwnedEquipement($db,$nom, $contenance, $pression, $user_id)
{
    $query = 'INSERT INTO equipement (nom,contenance, pression, user_id) VALUES (:nom, :contenance, :pression, :user_id)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':contenance', $contenance);
    $stmt->bindParam(':pression', $pression);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $db->lastInsertId();
}


// Ajoute un equipement qui n'appartient à personne
function addUnownedEquipement($db,$nom, $contenance, $pression)
{
    $query = 'INSERT INTO equipement (nom, contenance, pression, user_id) VALUES (:nom,:contenance, :pression, NULL)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':contenance', $contenance);
    $stmt->bindParam(':pression', $pression);
    $stmt->execute();
    return $db->lastInsertId();
}

function getDefaultEquipement($db){
    $query = 'SELECT * FROM equipement WHERE user_id IS NULL LIMIT 1';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetch();
}

function getEquipementById($db, $id)
{
    $query = 'SELECT * FROM equipement WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getEquipementsByUserId($db, $user_id)
{
    $query = 'SELECT * FROM equipement WHERE user_id = :user_id OR user_id IS NULL';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUnownedEquipements($db)
{
    $query = 'SELECT * FROM equipement WHERE user_id IS NULL';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function updateEquipement($db, $id,$nom, $contenance, $pression, $user_id)
{
    $query = 'UPDATE equipement SET contenance = :contenance, pression = :pression, user_id = :user_id, nom = :nom WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':contenance', $contenance);
    $stmt->bindParam(':pression', $pression);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deleteEquipement($db, $id)
{
    $query = 'DELETE FROM equipement WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
