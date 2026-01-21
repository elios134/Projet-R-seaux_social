<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/PostRepository.php';

class EditpostController extends Controller { // Correction du nom (Editpost)
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user'])) {
            header("Location: connexion");
            exit;
        }

        $postRepo = new PostRepository();
        $id = $_GET['id'] ?? null;
        $post = $postRepo->findById($id);

        if (!$post || $post['id_user'] != $_SESSION['user']['id']) {
            header("Location: ./");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postRepo->update($id, $_POST['title'], $_POST['content'], $_SESSION['user']['id']);
            header("Location: ./");
            exit;
        }

        return require_once __DIR__ . '/../views/edit_post.php';
    }
}