<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/UserRepository.php';

class InscriptionController extends Controller
{
    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userRepo = new UserRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['password_confirm'];
            $imageName = 'default.png';
            
            // Vérification de sécurité côté serveur
            if ($password !== $passwordConfirm) {
                $error = "Les mots de passe ne correspondent pas.";
                return require_once __DIR__ . '/../views/inscription.php';
            }

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $nomOrigine = $_FILES['avatar']['name'];
                $imageName = time() . "_" . $nomOrigine;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $imageName);
            }

            try {
                $userRepo->register($nom, $prenom, $mail, $password, $imageName);
                header("Location: connexion?msg=Inscription réussie !");
                exit;
            } catch (Exception $e) {
                $error = "Désolé, il y a eu un problème pendant l'inscription.";
            }
        }

        return require_once __DIR__ . '/../views/inscription.php';
    }
}