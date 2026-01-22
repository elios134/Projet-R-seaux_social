<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/UserRepository.php';

class AdminusersController extends Controller 
{
    public function start()
{
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: ./");
        exit;
    }

    $userRepo = new UserRepository();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = (int)$_POST['id'];
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $mail = trim($_POST['mail']);
        $userRepo->update($id, $nom, $prenom, $mail);
        
        header("Location: /admin-users");
        exit;
    }
    
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