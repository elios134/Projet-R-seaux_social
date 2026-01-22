<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/PostRepository.php';

class EditpostController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user'])) {
            header("Location: connexion");
            exit;
        }

        $postRepo = new PostRepository();
        $id = $_GET['id'] ?? null;
        $post = $postRepo->findById($id);

        // Correction: utiliser ->getId() au lieu de ['id']
        if (!$post || $post['id_user'] != $_SESSION['user']->getId()) {
            header("Location: ./");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Correction: utiliser ->getId()
            $postRepo->update($id, $_POST['title'], $_POST['content'], $_SESSION['user']->getId());
            header("Location: ./");
            exit;
        }

        return require_once __DIR__ . '/../views/edit_post.php';
    }
}