<?php
namespace PharmaFEFO\Entity;

class Batch {
    private int $id;
    private int $productId;
    private string $batchNumber;
    private string $expirationDate;
    private int $qtyAvailable;
    private string $status;

    // Getters pour accéder aux propriétés privées (Encapsulation)
    public function getId(): int { return $this->id; }
    public function getProductId(): int { return $this->productId; }
    public function getBatchNumber(): string { return $this->batchNumber; }
    public function getExpirationDate(): string { return $this->expirationDate; }
    public function getQtyAvailable(): int { return $this->qtyAvailable; }
    public function getStatus(): string { return $this->status; }

    // Setters (Si on veut modifier l'objet avant de l'enregistrer)
    public function setStatus(string $status): void {
        $this->status = $status;
    }
}
?>