<?php


require_once __DIR__ . "/../models/mn90Model.php";

class tableController extends Controller
{   
    // pour get la table
    public function get()
    {
        $table = Mn90\getTable($this->db);
        $this->response($table, 200);
    }
}
