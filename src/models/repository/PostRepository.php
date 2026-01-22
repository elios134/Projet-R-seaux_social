<?php
require_once __DIR__ . '/../Db.php';

class PostRepository extends Db
{
    public function create($title, $content, $id_user)
    {
        try {
            $db = self::connect();
            $sql = "INSERT INTO post (title, content, id_user) VALUES (:title, :content, :id_user)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':id_user' => $id_user
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function findAll()
    {
        $db = self::connect();
        $sql = "SELECT post.*, user.prenom, user.image AS u_image,
        (SELECT COUNT(*) FROM likes WHERE id_post = post.id) AS c_likes
        FROM post 
        INNER JOIN user ON post.id_user = user.id 
        ORDER BY post.created_at DESC";

        $results = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        $posts = [];
        foreach ($results as $data) {
            // On crée l'objet à partir du tableau associatif de la BDD
            $post = new \App\Models\Entity\Post($data);
            
            // On remplit les propriétés étendues
            $post->user_prenom = $data['prenom'];
            $post->user_image = $data['u_image'];
            $post->count_likes = $data['c_likes'];
            
            $posts[] = $post;
        }
        return $posts;
    }

    public function delete($id, $id_user)
    {
        $db = self::connect();
        $sql = "DELETE FROM post WHERE id = ? AND id_user = ?";
        return $db->prepare($sql)->execute([$id, $id_user]);
    }

    public function deleteByAdmin($id)
    {
        $db = self::connect();
        $sql = "DELETE FROM post WHERE id = ?";
        return $db->prepare($sql)->execute([$id]);
    }
}