<?php

require_once __DIR__ . "/../models/userModel.php";

class loginController extends Controller
{

    /**
     * POST method :p
     * Take a JSON object with the following fields:
     * - email
     * - password
     * 
     */
    public function post()
    {
        $data = $_POST;
        
        if($this->validateData($data,['email','password']) === false){
            $this->response(['error' => 'Invalid data'], 400);
        }

        if (User\verifyPassword($this->db, $data['email'], $data['password'])) {
            $user = User\getUserByMail($this->db, $data['email']);

            $session_id = bin2hex(random_bytes(16)); // Generate a random session ID
            User\updateSessionId($this->db, $user['id'], $session_id);


            $sendData = [
                'session_id' => $session_id,
                'user' =>[
                    'user_mail' => $user['user_mail'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'id' => $user['id'],
                ],
            ];
            $this->response($sendData, 200);
        } else {
            $this->response(['error' => 'Invalid email or password'], 401);
            Utils\debugLog('Invalid email or password: ' . json_encode($data));
        }
    }
}
