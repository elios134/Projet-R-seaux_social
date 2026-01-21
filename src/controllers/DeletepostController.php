<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/PostRepository.php';

class DeletepostController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['user']) && isset($_GET['id'])) {
            $postRepo = new PostRepository();
            $postRepo->delete($_GET['id'], $_SESSION['user']['id']);
        }
        
        header("Location: ./");
        exit;
    }
}