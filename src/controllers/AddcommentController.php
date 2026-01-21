<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class AddcommentController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['user']) && isset($_POST['content']) && isset($_GET['id'])) {
            $commentRepo = new CommentRepository();
            $content = $_POST['content'];
            $postId = $_GET['id'];
            $userId = $_SESSION['user']['id'];
            
            // On récupère le parent_id s'il existe dans le formulaire POST
            $parentId = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
            
            $commentRepo->create($content, $postId, $userId, $parentId);
        }

        header("Location: ./");
        exit;
    }
}