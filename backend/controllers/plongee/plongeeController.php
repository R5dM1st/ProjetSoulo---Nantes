<?php

require_once __DIR__ . "/../../models/plongee/PlongéesModel.php";
require_once __DIR__ . "/../../models/plongee/SettingsModel.php";

// Controller du profile plongée (vitesse de descente, vitesse de remontée, respiration)
class plongeeController extends Controller
{
    // Récupère le profil de plongée
    public function get()
    {
        if ($this->user == null) {
            //Get unowned
            $plongées = Plongee\getUnownedPubliquePlongee($this->db);
        } else {
            $plongées = Plongee\getPlongeeByUserId(
                $this->db,
                $this->user["id"]
            );
        }

        $this->response($plongées, 200);
    }

    // Ajoute une plongee
    //`profile_id=${profile_id}&equipement_id=${equipement_id}&profondeur=${profondeur}&duree=${duree}&date=${date}&nom=${nom}&private=${private}`,
    public function post()
    {
        if (
            !$this->validateData($_POST, [
                "profile_id",
                "equipement_id",
                "profondeur",
                "duree",
                "date",
                "nom",
                "private",
            ])
        ) {
            $this->response(null, 400);
            return;
        }

        if ($_POST["profondeur"] < 0 || $_POST["duree"] < 0) {
            Utils\debugLog("profondeur ou duree < 0");
            $this->response(null, 400);
            return;
        }

        $settings = PlongeeSettings\addPlongeeSettings(
            $this->db,
            $_POST["nom"] . " - settings",
            $_POST["profondeur"],
            $_POST["duree"],
            $_POST["respiration"]
        );

        $plongee = Plongee\addPlongee(
            $this->db,
            $_POST["nom"],
            $_POST["date"],
            $_POST["private"],
            $this->user == null ? null : $this->user["id"],
            $_POST["profile_id"],
            $settings,
            $_POST["equipement_id"]
        );

        if ($plongee == null) {
            $this->response(null, 500);
            return;
        }

        $this->response($plongee, 200);
    }

    public function delete()
    {
        //delete data de la forme d'une query string
        parse_str(file_get_contents("php://input"), $data);
        if (!$this->validateData($data, ["id"])) {
            $this->response(null, 400);
            return;
        }

        $plongee = Plongee\getPlongeeById($this->db, $data["id"]);

        if ($plongee == null) {
            $this->response(null, 404);
            return;
        }

        if ($plongee["user_id"] != $this->user["id"]) {
            $this->response(null, 403);
            return;
        }

        if (Plongee\deletePlongeeByID($this->db, $data["id"])) {
            $this->response(null, 200);
        } else {
            $this->response(null, 500);
        }
    }
}
