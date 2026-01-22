<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/PostRepository.php';

class LikeController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (isset($_SESSION['user']) && isset($_GET['id'])) {
            $postRepo = new PostRepository();
            // Correction: utiliser ->getId() au lieu de ['id']
            $postRepo->toggleLike($_GET['id'], $_SESSION['user']->getId());
        }
        
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? './')); 
        exit;
    }
}