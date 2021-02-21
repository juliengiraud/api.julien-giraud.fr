<?php

require_once(PATH_DTO . "/RequestBody.php");

class OperationDTO implements RequestBody {

    private $id;
    private $date;
    private $montant;
    private $commentaire;
    private $remboursable;

    public static function fromRequestBody() {
        $input = json_decode(
            file_get_contents("php://input")
        );
        if (!isset($input->data) || in_array(true, [
                !isset($input->data->date), !isset($input->data->montant),
                !isset($input->data->commentaire), !isset($input->data->remboursable)
            ]) || in_array("", [
                $input->data->date, $input->data->montant,
                $input->data->commentaire, $input->data->remboursable
            ])) {
            http_response_code(422);
            return null;
        }

        $operation = new OperationDTO();
        $operation->id = $input->data->id; // On check ailleurs
        $operation->date = $input->data->date;
        $operation->montant = $input->data->montant;
        $operation->commentaire = $input->data->commentaire;
        $operation->remboursable = $input->data->remboursable === "1";

        return $operation;
    }

    private function __construct() {
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getMontant(): float {
        return $this->montant;
    }

    public function getCommentaire(): string {
        return $this->commentaire;
    }

    public function isRemboursable(): bool {
        return $this->remboursable;
    }

}
