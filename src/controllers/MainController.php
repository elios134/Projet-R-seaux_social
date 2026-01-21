<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/PostRepository.php';
require_once __DIR__ . '/../models/repository/CommentRepository.php';

class MainController extends Controller
{
    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $postRepo = new PostRepository();
        $commentRepo = new CommentRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
            if (isset($_SESSION['user'])) {
                $postRepo->create(
                    $_POST['title'],
                    $_POST['content'],
                    $_SESSION['user']['id']
                );
                header("Location: ./");
                exit;
            }
        }


        $posts = $postRepo->findAll();
        $postsWithComments = [];

        foreach ($posts as $post) {
            $post['comments'] = $commentRepo->findByPost($post['id']);
            $postsWithComments[] = $post;
        }

        $posts = $postsWithComments;
        return require_once __DIR__ . '/../views/index.php';
    }
}
