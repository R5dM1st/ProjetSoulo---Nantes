<?php

namespace User;

/*
TABLE "user" (
    id SERIAL PRIMARY KEY,
    user_mail VARCHAR(150) UNIQUE,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    hash_password VARCHAR(100),
    session_id VARCHAR(100)
);
*/

function addUser($db, $user_mail, $nom, $prenom, $hash_password)
{
    $query = 'INSERT INTO "user" (user_mail, nom, prenom, hash_password,session_id) VALUES (:user_mail, :nom, :prenom, :hash_password,NULL)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_mail', $user_mail);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':hash_password', $hash_password);
    $stmt->execute();
    return $db->lastInsertId();
}

function getUserByMail($db, $user_mail)
{
    $query = 'SELECT * FROM "user" WHERE user_mail = :user_mail';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_mail', $user_mail);
    $stmt->execute();
    return $stmt->fetch();
}

function getUserById($db, $id)
{
    $query = 'SELECT * FROM "user" WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getBySessionId($db, $session_id)
{
    $query = 'SELECT * FROM "user" WHERE session_id = :session_id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->execute();
    return $stmt->fetch();
}

function updateSessionId($db, $id, $session_id)
{
    $query = 'UPDATE "user" SET session_id = :session_id WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deleteSessionId($db, $id)
{
    $query = 'UPDATE "user" SET session_id = NULL WHERE id = :id';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function verifyPassword($db, $user_mail, $password)
{
    $user = getUserByMail($db, $user_mail);
    if ($user === false) {
        return false;
    }
    return password_verify($password, $user['hash_password']);
}
