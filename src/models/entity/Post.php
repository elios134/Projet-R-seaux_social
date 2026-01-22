<?php
namespace App\Models\Entity;

class Post {
    private $id;
    private $title;
    private $content;
    private $id_user; 
    private $created_at;

    // Propriétés publiques pour les données jointes (User, Likes, etc.)
    public $comments = []; 
    public $user_prenom;
    public $user_image;
    public $count_likes;

    public function __construct($data = []) {
        // On vérifie que $data est bien un tableau avant d'y accéder
        if (is_array($data)) {
            $this->id = $data['id'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->content = $data['content'] ?? null;
            $this->id_user = $data['id_user'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
        }
        $this->comments = [];
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getIdUser() { return $this->id_user; }
    public function getCreatedAt() { return $this->created_at; }
    
    // Méthodes pour faciliter l'accès aux données du créateur
    public function getUserPrenom() { return $this->user_prenom; }
    public function getUserImage() { return $this->user_image; }

    public function setTitle($title) { $this->title = $title; }
    public function setContent($content) { $this->content = $content; }
}