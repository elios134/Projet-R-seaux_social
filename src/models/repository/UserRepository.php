<?php
require_once __DIR__ . '/../Db.php';

class UserRepository extends Db
{
    public function register($nom, $prenom, $mail, $password, $image)
    {
        $db = self::connect();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';

        $sql = "INSERT INTO user (nom, prenom, mail, password, image, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$nom, $prenom, $mail, $hash, $image, $role]);
    }

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

    public function findAll()
    {
        $db = self::connect();
        return $db->query("SELECT * FROM user ORDER BY nom ASC")->fetchAll();
    }

    public function delete($id)
    {
        $db = self::connect();
        return $db->prepare("DELETE FROM user WHERE id = ?")->execute([$id]);
    }

   public function update($id, $nom, $prenom, $mail, $role)
{
    $db = self::connect();
    $sql = "UPDATE user SET nom = ?, prenom = ?, mail = ?, role = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$nom, $prenom, $mail, $role, $id]);
}
}