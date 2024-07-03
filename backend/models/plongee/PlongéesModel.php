<?php



namespace Plongee;

/*
CREATE TABLE plongee (
    id SERIAL PRIMARY KEY,
    date DATE,
    private BOOLEAN,
    user_id INT,
    plongee_profile_id INT,
    plongee_settings_id INT,
    bouteille_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id),
    FOREIGN KEY (plongee_profile_id) REFERENCES plongee_profile(id),
    FOREIGN KEY (plongee_settings_id) REFERENCES plongee_settings(id),
    FOREIGN KEY (bouteille_id) REFERENCES bouteille(id)
);
*/

function addPlongee($db, $nom, $date, $private, $user_id, $plongee_profile_id, $plongee_settings_id, $equipement_id)
{
    $query = 'INSERT INTO plongee (date, nom,private, user_id, plongee_profile_id, plongee_settings_id, equipement_id) VALUES (:date, :nom, :private, :user_id, :plongee_profile_id, :plongee_settings_id, :equipement_id)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':private', $private);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':plongee_profile_id', $plongee_profile_id);
    $stmt->bindParam(':plongee_settings_id', $plongee_settings_id);
    $stmt->bindParam(':equipement_id', $equipement_id);
    $stmt->execute();
    return $db->lastInsertId();
}


function getPlongeeByUserId($db, $user_id)
{
    $query = 'SELECT p.*,
    pp.nom as profile_nom,pp.vitesse_desc, pp.vitesse_asc, pp.respiration,
    ps.nom as settings_nom, ps.profondeur, ps.duree,
    e.nom as equipement_nom,e.contenance, e.pression
        FROM plongee as p 
        JOIN plongee_profile as pp ON p.plongee_profile_id = pp.id 
        JOIN plongee_settings as ps ON p.plongee_settings_id = ps.id 
        JOIN equipement as e ON p.equipement_id = e.id 
        WHERE p.user_id = :user_id
        ORDER BY p.date DESC';

    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUnownedPubliquePlongee($db)
{
    $query =
        'SELECT p.*,
    pp.nom as profile_nom,pp.vitesse_desc, pp.vitesse_asc, pp.respiration,
    ps.nom as settings_nom, ps.profondeur, ps.duree,
    e.nom as equipement_nom,e.contenance, e.pression
        FROM plongee as p 
        JOIN plongee_profile as pp ON p.plongee_profile_id = pp.id 
        JOIN plongee_settings as ps ON p.plongee_settings_id = ps.id 
        JOIN equipement as e ON p.equipement_id = e.id 
        WHERE p.user_id = NULL OR p.private = FALSE
        ORDER BY p.date DESC';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}


function getPlongeeById($db, $id)
{
    $query = 'SELECT p.*,
    pp.nom as profile_nom,pp.vitesse_desc, pp.vitesse_asc, pp.respiration,
    ps.nom as settings_nom, ps.profondeur, ps.duree,
    e.nom as equipement_nom,e.contenance, e.pression
        FROM plongee as p 
        JOIN plongee_profile as pp ON p.plongee_profile_id = pp.id 
        JOIN plongee_settings as ps ON p.plongee_settings_id = ps.id 
        JOIN equipement as e ON p.equipement_id = e.id 
    WHERE p.id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}


function deletePlongeeByID($db, $id)
{
    $query = 'DELETE FROM plongee WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->rowCount();
}
