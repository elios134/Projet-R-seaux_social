<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/UserRepository.php';

class AdminusersController extends Controller 
{
    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Vérification des droits admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ./");
            exit;
        }

        $userRepo = new UserRepository();

        // 2. Logique de suppression
        if (isset($_GET['delete'])) {
            $idToDelete = (int)$_GET['delete'];
            if ($idToDelete !== (int)$_SESSION['user']['id']) {
                $userRepo->delete($idToDelete);
                header("Location: /admin-users");
                exit;
            }
        }
        $users = $userRepo->findAll();
        require_once __DIR__ . '/../views/admin-users.php';
    }
}