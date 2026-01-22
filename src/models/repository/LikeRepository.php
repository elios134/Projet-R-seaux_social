<?php
require_once __DIR__ . '/../Db.php';
class LikeRepository extends Db {
    public function getLikesForPost($postId) {
        $db = self::connect();
        $sql = "SELECT COUNT(*) as total FROM likes WHERE id_post = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetch()['total'];
    }

    public function checkIfUserLiked($postId, $userId) {
        $db = self::connect();
        $sql = "SELECT id FROM likes WHERE id_post = ? AND id_user = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$postId, $userId]);
        return $stmt->fetch() ? true : false;
    }
}