<?php
require_once __DIR__ . '/../Db.php';

class CommentRepository extends Db
{
    public function findByPost($postId)
    {
        $db = self::connect();
        $sql = "SELECT comment.*, user.prenom, user.image 
                FROM comment 
                INNER JOIN user ON comment.id_user = user.id 
                WHERE comment.id_post = ? 
                ORDER BY comment.id ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM comment WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($content, $postId, $userId, $parentId = null)
    {
        $db = self::connect();
        $sql = "INSERT INTO comment (content, id_post, id_user, parent_id) VALUES (?, ?, ?, ?)";
        return $db->prepare($sql)->execute([$content, $postId, $userId, $parentId]);
    }

    public function delete($id)
    {
        $db = self::connect();
        $sql = "DELETE FROM comment WHERE id = ?";
        return $db->prepare($sql)->execute([$id]);
    }
}