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
            echo "Erreur lors de la création du post : " . $e->getMessage();
            return false;
        }
    }

    public function findAll()
    {
        $db = self::connect();
        $sql = "SELECT post.*, user.prenom, user.image AS user_image,
        (SELECT COUNT(*) FROM likes WHERE id_post = post.id) AS count_likes
        FROM post 
        INNER JOIN user ON post.id_user = user.id 
        ORDER BY post.created_at DESC";

        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleLike($postId, $userId)
    {
        $db = self::connect();
        $check = $db->prepare("SELECT id FROM likes WHERE id_post = ? AND id_user = ?");
        $check->execute([$postId, $userId]);

        if ($check->fetch()) {
            $req = $db->prepare("DELETE FROM likes WHERE id_post = ? AND id_user = ?");
        } else {
            $req = $db->prepare("INSERT INTO likes (id_post, id_user) VALUES (?, ?)");
        }
        return $req->execute([$postId, $userId]);
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

    public function update($id, $title, $content, $id_user)
    {
        $db = self::connect();
        $sql = "UPDATE post SET title = ?, content = ? WHERE id = ? AND id_user = ?";
        return $db->prepare($sql)->execute([$title, $content, $id, $id_user]);
    }

    public function findById($id)
    {
        $db = self::connect();
        $sql = "SELECT * FROM post WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
