<?php

require_once __DIR__ . "/../models/userModel.php";

class registerController extends Controller
{

    /**
     * POST method
     * Take a JSON object with the following fields:
     * - email
     * - nom
     * - prenom
     * - password (must be >= 8 characters ...)
     * 
     * test json input:
        {
            "email": "jean.michel@gmail.com",
            "nom": "Michel",
            "prenom": "Jean",
            "password": "12345678"

        }
     */
    public function post()
    {
        $data = $_POST;

        if ( // Data verification
            $this->validateData($data, ['email', 'nom', 'prenom', 'password']) === false ||
            filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false ||
            Utils\VerifyStrongPassword($data['password']) === false
        ) {
            $this->response(['error' => 'Invalid data'], 400);
            Utils\debugLog('Invalid data: ' . json_encode($data));
            return;
        }

        try {
            User\addUser(
                $this->db,
                $data['email'],
                $data['nom'],
                $data['prenom'],
                password_hash($data['password'], PASSWORD_DEFAULT)
            );
        } catch (PDOException $e) {
            $this->response(['error' => 'User already exists'], 400);
            Utils\debugLog('User already exists: ' . json_encode($data));
            return;
        }


        $this->response(['message' => 'User created'], 201);
    }
}
