<?php
namespace App\Models\Entity;

class Comment {
    private $id;
    private $content;
    private $id_post;
    private $id_user;
    private $parent_id;
    private $date;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->id_post = $data['id_post'] ?? null;
        $this->id_user = $data['id_user'] ?? null;
        $this->parent_id = $data['parent_id'] ?? null;
        $this->date = $data['date'] ?? null;
    }

    public function getId() { return $this->id; }
    public function getContent() { return $this->content; }
    public function getIdPost() { return $this->id_post; }
    public function getIdUser() { return $this->id_user; }
    public function getParentId() { return $this->parent_id; }
    public function getDate() { return $this->date; }
}