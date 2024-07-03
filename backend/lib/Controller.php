<?php

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/userModel.php";


class Controller
{
    protected $db;

    protected $accessToken = null;

    protected $user = null; // != null if the user is connected


    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->accessToken = $this->accessToken();
        if ($this->accessToken) {
            $this->user = User\getBySessionId($this->db, $this->accessToken);
        }
        
    }


    //handle the execution of the REST API
    public function execute()
    {
        
        $method = $_SERVER['REQUEST_METHOD'];
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            $this->response(['message' => 'Method not allowed'], 405);
        }
    }


    protected function response($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }



    /*
    quickly check if all the fields are present in the data
    */
    protected function validateData($data, $fields)
    {
        foreach ($fields as $field) {
            if (!isset($data[$field])) {
                return false;
            }

        }
        return true;
    }


    protected function accessToken()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $accessToken =$headers['Authorization'];
            if (preg_match('/Bearer (.*)/', $accessToken, $tab))
                $accessToken = $tab[1];
            return $accessToken;
        }
        return null;
    }


   


    /**
     * Example of a GET method
     * 
     * public function get()
     * {
     *    //get the data from the database
     * ...
     * }
     * 
     * we can do the same for the other methods (POST, PUT, DELETE)
     */
}
