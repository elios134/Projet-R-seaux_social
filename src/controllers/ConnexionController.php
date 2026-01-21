<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/UserRepository.php';

class ConnexionController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userRepo = new UserRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $userRepo->findByEmail($_POST['login_mail']);
            
            // Vérification des identifiants
            if ($user && password_verify($_POST['login_pass'], $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: /");
                exit;
            }
            // Redirection avec paramètre d'erreur
            header("Location: /connexion?error=1");
            exit;
        }

        return require_once __DIR__ . '/../views/connexion.php';
    }
}