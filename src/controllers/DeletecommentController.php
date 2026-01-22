<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class DeletecommentController extends Controller {
    public function start() {
        if (isset($_SESSION['user']) && isset($_GET['id'])) {
            $commentRepo = new CommentRepository();
            $comment = $commentRepo->findById($_GET['id']);
            
            if ($comment) {
                $userId = $_SESSION['user']->getId();
                $userRole = $_SESSION['user']->getRole();
            
                // Autoriser si c'est l'auteur OU un admin/modo
                if ($comment['id_user'] == $userId || $userRole === 'admin' || $userRole === 'modo') {
                    $commentRepo->delete($_GET['id']);
                }
            }
        }
        header("Location: /");
        exit;
    }
}