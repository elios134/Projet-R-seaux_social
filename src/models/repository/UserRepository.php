<?php
require_once __DIR__ . '/../Db.php';
require_once __DIR__ . '/../entity/User.php';
use App\Models\Entity\User;

class UserRepository extends Db
{
    public function findByEmail($mail)
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM user WHERE mail = ?");
        $stmt->execute([$mail]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new User($data) : null;
    }

    public function findAll()
    {
        $db = self::connect();
        $results = $db->query("SELECT * FROM user ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($results as $data) {
            $users[] = new User($data);
        }
        return $users;
    }

    // AJOUT: Méthode register manquante
    public function register($nom, $prenom, $mail, $password, $imageName)
    {
        $db = self::connect();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (nom, prenom, mail, password, image, role) VALUES (?, ?, ?, ?, ?, 'user')";
        return $db->prepare($sql)->execute([$nom, $prenom, $mail, $hashedPassword, $imageName]);
    }

    public function updateImage($userId, $imageName)
    {
        $db = self::connect();
        return $db->prepare("UPDATE user SET image = ? WHERE id = ?")->execute([$imageName, $userId]);
    }

    public function update($id, $nom, $prenom, $mail, $role)
    {
        $db = self::connect();
        $sql = "UPDATE user SET nom = ?, prenom = ?, mail = ?, role = ? WHERE id = ?";
        return $db->prepare($sql)->execute([$nom, $prenom, $mail, $role, $id]);
    }

    public function delete($id)
    {
        $db = self::connect();
        return $db->prepare("DELETE FROM user WHERE id = ?")->execute([$id]);
    }
}