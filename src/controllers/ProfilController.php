<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/repository/UserRepository.php';

class ProfilController extends Controller {
    public function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header("Location: /connexion");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {

            if ($_FILES['avatar']['error'] === 0) {
                
                $userRepo = new UserRepository();
                $dossierDestination = __DIR__ . "/../../public/uploads/profiles/";
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $nouveauNom = time() . "." . $extension; 
                $destinationFinale = $dossierDestination . $nouveauNom;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destinationFinale)) {
                   
                    $userRepo->updateImage($_SESSION['user']->getId(), $nouveauNom);
                    
                    
                    $_SESSION['user']->setImage($nouveauNom);
                    
                    header("Location: /profil?msg=Image mise à jour");
                    exit;

                } else {
                    echo "Erreur : Impossible de déplacer le fichier.";
                }
            } else {
                echo "Erreur : Le fichier est invalide.";
            }
        }
        return require_once __DIR__ . '/../views/profil.php';
    }
}