<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/PostRepository.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class MainController extends Controller
{
    public function start()
    {
        $postRepo = new PostRepository();
        $commentRepo = new CommentRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
            if (isset($_SESSION['user'])) {
                $postRepo->create(
                    $_POST['title'],
                    $_POST['content'],
                    $_SESSION['user']->getId() 
                );
                header("Location: ./");
                exit;
            }
        }

        // 1. findAll() renvoie déjà une liste d'OBJETS Post (voir modif Repository plus bas)
        $posts = $postRepo->findAll();

        foreach ($posts as $post) {
            // 2. Plus de "new Post($postData)", $post est déjà l'objet.
            // On lui ajoute juste ses commentaires.
            $post->comments = $commentRepo->findByPost($post->getId());
        }

        return require_once __DIR__ . '/../views/home.php';
    }
}