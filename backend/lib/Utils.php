<?php

namespace Utils;

use Exception;

function VerifyStrongPassword($password)
{
    if (strlen($password) < 8) { //TODO: On peut possiblement améliorer la vérification du mot de passe
        return false;
    }
    return true;
}

function debugLog($data)
{
    try{
    file_put_contents('debug.log', print_r($data, true) . "\n", FILE_APPEND);
    } catch (Exception $e){
        return;
    }
}
