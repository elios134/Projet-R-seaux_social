<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/PostRepository.php';

class DeletepostController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['user']) && isset($_GET['id'])) {
            $postRepo = new PostRepository();
            $role = $_SESSION['user']->getRole();
            $userId = $_SESSION['user']->getId();

            if ($role === 'admin' || $role === 'modo') {  
                $postRepo->deleteByAdmin($_GET['id']);
            } else {
                $postRepo->delete($_GET['id'], $userId);
            }
        }
        
        header("Location: ./");
        exit;
    }
}