<?php
require_once __DIR__ . '/../Db.php';

class UserRepository extends Db
{
    // Inscription
    public function register($nom, $prenom, $mail, $password, $image)
    {
        $db = self::connect();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (nom, prenom, mail, password, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$nom, $prenom, $mail, $hash, $image]);
    }

    // Connexion
    public function findByEmail($mail)
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM user WHERE mail = ?");
        $stmt->execute([$mail]);
        return $stmt->fetch();
    }

    public function updateImage($userId, $imageName)
    {
        $db = self::connect();
        $sql = "UPDATE user SET image = ? WHERE id = ?";
        return $db->prepare($sql)->execute([$imageName, $userId]);
    }
}
