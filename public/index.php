<?php
// index.php

// Chargement des bases
require_once(__DIR__ . "/../src/models/Db.php");
require_once(__DIR__ . "/../src/models/repository/PostRepository.php");
require_once(__DIR__ . "/../src/models/repository/UserRepository.php");
require_once(__DIR__ . "/../src/models/repository/CommentRepository.php");

// Chargement du coeur et des contrôleurs
require_once(__DIR__ . "/../src/controllers/Controller.php");
require_once(__DIR__ . "/../src/controllers/MainController.php");

require_once(__DIR__ . "/../src/controllers/ConnexionController.php");
require_once(__DIR__ . "/../src/controllers/DeconnexionController.php");
require_once(__DIR__ . "/../src/controllers/InscriptionController.php");

require_once(__DIR__ . "/../src/controllers/DeletepostController.php");
require_once(__DIR__ . "/../src/controllers/EditcommentController.php");
require_once(__DIR__ . "/../src/controllers/EditpostController.php");
require_once(__DIR__ . "/../src/controllers/AddcommentController.php");
require_once(__DIR__ . "/../src/controllers/DeletecommentController.php");
require_once(__DIR__ . "/../src/controllers/AdminusersController.php");


require_once(__DIR__ . "/../src/controllers/LikeController.php");
require_once(__DIR__ . "/../src/controllers/ProfilController.php");


require_once(__DIR__ . "/../src/core/Router.php");
try {
    $router = new Router();
    $router->start();
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}