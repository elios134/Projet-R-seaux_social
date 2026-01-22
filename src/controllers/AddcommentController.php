<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class AddcommentController extends Controller {
    public function start() {
        if (isset($_SESSION['user']) && isset($_POST['content']) && isset($_GET['id'])) {
            $commentRepo = new CommentRepository();
            
            // On utilise l'ID de l'objet User
            $userId = $_SESSION['user']->getId();
            $postId = $_GET['id'];
            $content = $_POST['content'];
            $parentId = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
            
            $commentRepo->create($content, $postId, $userId, $parentId);
        }

        header("Location: /");
        exit;
    }
}