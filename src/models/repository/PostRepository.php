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
            $post = new \App\Models\Entity\Post($data);
            
            $post->user_prenom = $data['prenom'];
            $post->user_image = $data['u_image'];
            $post->count_likes = $data['c_likes'];
            
            $posts[] = $post;
        }
        return $posts;
    }

    // AJOUT: Méthode findById manquante
    public function findById($id)
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM post WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // AJOUT: Méthode update manquante
    public function update($id, $title, $content, $userId)
    {
        $db = self::connect();
        $sql = "UPDATE post SET title = ?, content = ? WHERE id = ? AND id_user = ?";
        return $db->prepare($sql)->execute([$title, $content, $id, $userId]);
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

    // AJOUT: Méthode toggleLike manquante
    public function toggleLike($postId, $userId)
    {
        $db = self::connect();
        
        // Vérifier si le like existe déjà
        $stmt = $db->prepare("SELECT id FROM likes WHERE id_post = ? AND id_user = ?");
        $stmt->execute([$postId, $userId]);
        
        if ($stmt->fetch()) {
            // Unlike - supprimer le like
            $db->prepare("DELETE FROM likes WHERE id_post = ? AND id_user = ?")->execute([$postId, $userId]);
        } else {
            // Like - ajouter le like
            $db->prepare("INSERT INTO likes (id_post, id_user) VALUES (?, ?)")->execute([$postId, $userId]);
        }
    }
}