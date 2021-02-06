<?php

require_once(PATH_MODEL . "/FromObject.php");

class Operation implements JsonSerializable, FromObject {

    private $id;
    private $date;
    private $montant;
    private $commentaire;
    private $remboursable;

    public function __construct() {
    }

    public static function fromObject($operation) {
        $newOperation = new Operation();
        $newOperation->id = $operation->id;
        $newOperation->date = $operation->date;
        $newOperation->montant = $operation->montant;
        $newOperation->commentaire = $operation->commentaire;
        $newOperation->remboursable = $operation->remboursable === "1";
        return $newOperation;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate($date): void {
        $this->date = $date;
    }

    public function getMontant(): float {
        return $this->montant;
    }

    public function setMontant($montant): void {
        $this->montant = $montant;
    }

    public function getCommentaire(): string {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire): void {
        $this->commentaire = $commentaire;
    }

    public function isRemboursable(): bool {
        return $this->remboursable;
    }

    public function setRemboursable($remboursable): void {
        $this->remboursable = $remboursable;
    }

    public function jsonSerialize(): array {
        return [
            "id" => $this->id,
            "date" => $this->date,
            "montant" => $this->montant,
            "commentaire" => $this->commentaire,
            "remboursable" => $this->remboursable === true
        ];
    }

}
