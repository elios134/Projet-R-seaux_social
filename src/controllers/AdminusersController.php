<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/UserRepository.php';

class AdminusersController extends Controller 
{
    public function start()
    {
        // CORRECTION : ->getRole()
        if (!isset($_SESSION['user']) || $_SESSION['user']->getRole() !== 'admin') {
            header("Location: ./");
            exit;
        }

        $userRepo = new UserRepository();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
            $userRepo->update((int)$_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['role']);
            header("Location: /admin-users");
            exit;
        }
        
        if (isset($_GET['delete'])) {
            $idToDelete = (int)$_GET['delete'];
            // CORRECTION : ->getId()
            if ($idToDelete !== (int)$_SESSION['user']->getId()) {
                $userRepo->delete($idToDelete);
                header("Location: /admin-users");
                exit;
            }
        }
        
        $users = $userRepo->findAll();
        return require_once __DIR__ . '/../views/admin-users.php';
    }
}