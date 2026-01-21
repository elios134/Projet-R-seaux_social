<?php
require_once __DIR__ . '/Controller.php';

class DeconnexionController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location: /connexion");
        exit;
    }
}