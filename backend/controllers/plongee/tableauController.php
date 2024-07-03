<?php

require_once __DIR__ . "/../../models/mn90Model.php";
require_once __DIR__ . "/../../models/plongee/PlongéesModel.php";
require_once __DIR__ . "/../../models/plongee/ResultModel.php";
require_once __DIR__ . "/../../models/plongee/TableModel.php";

class tableauController extends Controller
{
    // pour get le tableau de la plongée
    public function get()
    {
        if ($this->validateData($_GET, ["id"])) {
            $plongee = Plongee\getPlongeeById($this->db, $_GET["id"]);
            if (
                $plongee == null ||
                ($plongee["user_id"] != $this->user["id"] &&
                    $plongee["private"] == 1)
            ) {
                $this->response(null, 403);
                return;
            }

            $mntable = Mn90\getRow(
                $this->db,
                $plongee["profondeur"],
                $plongee["duree"]
            );
            $result = ResultTable\getTableau($plongee, $mntable);
            $this->response($result, 200);
        } else {
            $this->response(null, 400);
        }
    }
}
