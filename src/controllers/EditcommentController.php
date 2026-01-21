<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class EditcommentController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: /connexion");
            exit;
        }

        $commentRepo = new CommentRepository();
        $id = $_GET['id'] ?? null;
        $comment = $commentRepo->findById($id);

        if (!$comment || $comment['id_user'] != $_SESSION['user']['id']) {
            header("Location: /");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentRepo->update($id, $_POST['content'], $_SESSION['user']['id']);
            header("Location: /");
            exit;
        }

        return require_once __DIR__ . '/../views/edit_comment.php';
    }
}