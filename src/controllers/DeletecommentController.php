<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class DeletecommentController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['user']) && isset($_GET['id'])) {
            $commentRepo = new CommentRepository();
            $comment = $commentRepo->findById($_GET['id']);
            
            if ($comment && $comment['id_user'] == $_SESSION['user']['id']) {
                $commentRepo->delete($_GET['id'], $_SESSION['user']['id']);
            }
        }
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? './'));
        exit;
    }
}