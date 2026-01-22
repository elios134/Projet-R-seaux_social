<?php
namespace App\Models\Entity;

class User {
    private $id;
    private $nom;
    private $prenom;
    private $mail;
    private $password;
    private $image;
    private $role;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'] ?? null;
        $this->prenom = $data['prenom'] ?? null;
        $this->mail = $data['mail'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->image = $data['image'] ?? 'default.png';
        $this->role = $data['role'] ?? 'user';
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getFullName() { return $this->prenom . " " . $this->nom; }
    public function getMail() { return $this->mail; }
    public function getImage() { return $this->image; }
    public function getRole() { return $this->role; }
    public function getPassword() { return $this->password; }

    // Setters
    public function setNom($nom) { $this->nom = $nom; }
    public function setImage($image) { $this->image = $image; }
}