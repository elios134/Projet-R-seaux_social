<?php
namespace App\Models\Entity;

class Like {
    private $id;
    private $id_post;
    private $id_user;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->id_post = $data['id_post'] ?? null;
        $this->id_user = $data['id_user'] ?? null;
    }

    public function getId() { return $this->id; }
    public function getIdPost() { return $this->id_post; }
    public function getIdUser() { return $this->id_user; }
}