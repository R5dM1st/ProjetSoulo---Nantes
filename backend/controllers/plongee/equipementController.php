<?php

require_once __DIR__ . "/../../models/plongee/EquipementModel.php";

// Controller du profile plongée (vitesse de descente, vitesse de remontée, respiration)
class equipementController extends Controller
{
    // Récupère le profil de plongée
    public function get()
    {
        if ($this->validateData($_GET, ["equipement_id"])) {
            $profile = Equipement\getEquipementById(
                $this->db,
                $_GET["equipement_id"]
            );
            $this->response($profile);
        } else {
            if ($this->user != null) {
                $profiles = Equipement\getEquipementsByUserId(
                    $this->db,
                    $this->user["id"]
                );
                $this->response($profiles);
            } else {
                $profiles = Equipement\getDefaultEquipement($this->db);
                $this->response([$profiles]);
            }
        }
    }

    // Ajoute un equipement
    // {
    //     "nom": "bouteille",
    //     "contenance": 10,
    //     "pression": 200
    // }
    public function post()
    {
        if ($this->user == null) {
            $this->response(null, 401);
            return;
        }
        if ($this->validateData($_POST, ["nom", "contenance", "pression"])) {
            if ($_POST["pression"] < 0 || $_POST["contenance"] < 0) {
                $this->response(null, 400);
                return;
            }
            $equipement = Equipement\addOwnedEquipement(
                $this->db,
                $_POST["nom"],
                $_POST["contenance"],
                $_POST["pression"],
                $this->user["id"]
            );
            $this->response($equipement);
        } else {
            $this->response(null, 400);
        }
    }

    public function put()
    {
        parse_str(file_get_contents("php://input"), $data);
        if ($this->user == null) {
            $this->response(null, 401);
            return;
        }
        if (
            $this->validateData($data, ["id", "nom", "contenance", "pression"])
        ) {
            if ($_POST["pression"] < 0 || $_POST["contenance"] < 0) {
                $this->response(null, 400);
                return;
            }

            //check if the equipement belongs to the user
            $equipement = Equipement\getEquipementById($this->db, $data["id"]);
            if ($equipement["user_id"] != $this->user["id"]) {
                $this->response(null, 403);
                return;
            }

            $equipement = Equipement\updateEquipement(
                $this->db,
                $data["id"],
                $data["nom"],
                $data["contenance"],
                $data["pression"],
                $this->user["id"]
            );
            $this->response($equipement);
        } else {
            $this->response(null, 400);
        }
    }

    public function delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        if ($this->user == null) {
            $this->response(null, 401);
            return;
        }
        if ($this->validateData($data, ["id"])) {
            //check if the equipement belongs to the user
            $equipement = Equipement\getEquipementById($this->db, $data["id"]);
            if ($equipement["user_id"] != $this->user["id"]) {
                Utils\debugLog($equipement);
                Utils\debugLog($data);
                $this->response(null, 403);
                return;
            }

            $equipement = Equipement\deleteEquipement($this->db, $data["id"]);
            $this->response($equipement);
        } else {
            $this->response(null, 400);
        }
    }
}
