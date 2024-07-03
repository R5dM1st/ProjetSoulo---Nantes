<?php

require_once __DIR__ . "/../../models/plongee/ProfileModel.php";

// Controller du profile plongée (vitesse de descente, vitesse de remontée, respiration)
class profileController extends Controller
{
    // Récupère le profil de plongée
    public function get()
    {
        if ($this->validateData($_GET, ["profile_id"])) {
            $profile = PlongeeProfile\getProfileById(
                $this->db,
                $_GET["profile_id"]
            );
            $this->response($profile);
        } else {
            if ($this->user != null) {
                $profiles = PlongeeProfile\getProfileByUserId(
                    $this->db,
                    $this->user["id"]
                );
                $this->response($profiles);
            } else {
                $profiles = PlongeeProfile\getDefaultProfile($this->db);
                $this->response([$profiles]);
            }
        }
    }

    /**
     * Ajoute un profile
     {
        "nom": "profile1",
        "vitesse_descente": 10,
        "vitesse_remontee": 10,
        "respiration": 10
     }
     */
    public function post()
    {
        if ($this->user == null) {
            $this->response(null, 401);
            return;
        }

        if (
            $this->validateData($_POST, [
                "vitesse_descente",
                "vitesse_remontee",
                "respiration",
            ])
        ) {
            if (
                $_POST["vitesse_descente"] < 0 ||
                $_POST["vitesse_remontee"] < 0 ||
                $_POST["respiration"] < 0
            ) {
                $this->response(null, 400);
                return;
            }
            $profile = PlongeeProfile\addProfile(
                $this->db,
                $_POST["nom"],
                $_POST["vitesse_descente"],
                $_POST["vitesse_remontee"],
                $_POST["respiration"],
                $this->user["id"]
            );
            $this->response($profile);
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
            $this->validateData($data, [
                "id",
                "nom",
                "vitesse_descente",
                "vitesse_remontee",
                "respiration",
            ])
        ) {
            if (
                $_POST["vitesse_descente"] < 0 ||
                $_POST["vitesse_remontee"] < 0 ||
                $_POST["respiration"] < 0
            ) {
                $this->response(null, 400);
                return;
            }

            //check if the profile belongs to the user
            $profile = PlongeeProfile\getProfileById($this->db, $data["id"]);
            if ($profile["user_id"] != $this->user["id"]) {
                $this->response(null, 403);
                return;
            }

            $profile = PlongeeProfile\updateProfile(
                $this->db,
                $data["id"],
                $data["nom"],
                $data["vitesse_descente"],
                $data["vitesse_remontee"],
                $data["respiration"],
                $this->user["id"]
            );
            $this->response($profile);
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
            $profile = PlongeeProfile\getProfileById($this->db, $data["id"]);
            if ($profile["user_id"] != $this->user["id"]) {
                $this->response(null, 403);
                return;
            }

            PlongeeProfile\deleteProfile($this->db, $data["id"]);
            $this->response(null);
        } else {
            $this->response(null, 400);
        }
    }
}
