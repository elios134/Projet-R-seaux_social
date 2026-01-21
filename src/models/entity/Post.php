<?php
namespace App\Models\Entity;

class Post {
    private $id;
    private $title;
    private $content;
    private $id_user; 

    
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->id_user = $data['id_user'] ?? null;
    }

    
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getIdUser() { return $this->id_user; }

    
    public function setTitle($title) { $this->title = $title; }
    public function setContent($content) { $this->content = $content; }
}