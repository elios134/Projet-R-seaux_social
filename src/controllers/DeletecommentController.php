<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class DeletecommentController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (isset($_SESSION['user']) && isset($_GET['id'])) {
            $commentRepo = new CommentRepository();
            $comment = $commentRepo->findById($_GET['id']);
            
            if ($comment) {
                $userId = $_SESSION['user']['id'];
                $userRole = $_SESSION['user']['role'];
            
                if ($comment['id_user'] == $userId || $userRole === 'admin' || $userRole === 'modo') {
                  
                    $commentRepo->delete($_GET['id'], $comment['id_user']);
                }
            }
        }
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? './'));
        exit;
    }
}