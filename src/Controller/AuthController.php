<?php
namespace PharmaFEFO\Controller;

use PharmaFEFO\Config\Database;
use PharmaFEFO\Repository\UserRepository;

class AuthController {
    
    public function loginProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $database = new Database();
            $db = $database->getConnection();
            $userRepo = new UserRepository($db);

            // 1. Kanjebdo l'utilisateur mn la base de données
            $user = $userRepo->findByEmail($email);

            // 2. Kan-vérifiw wach l'utilisateur kayn W wach l'mot de passe s7i7
            // NB: password_verify() katqaren l'mot de passe l3adi m3a l'Hash li f la base de données.
            // Ila knti derti les mots de passe 3adiyin (Texte clair) f SQL, dir: if ($user && $user['password'] === $password)
            if ($user && password_verify($password, $user['password'])) {
                
                // 3. Kolchi mzyan -> Kan7ellou Session jdida
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role']; // Matalan: 'PHARMACIEN' wla 'PREPARATEUR'

                // Kandiw l'utilisateur l'Dashboard
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                // 4. Mot de passe awla email ghalet -> Kanrejj3oh l'formulaire m3a erreur
                header("Location: index.php?action=login&error=invalid_credentials");
                exit();
            }
        }
    }

    // Fonction bach y-déconnecta l'utilisateur (Logout)
    public function logout() {
        session_start();
        session_unset(); // Kanmes7ou ga3 les variables
        session_destroy(); // Kanherrsou la session kamla
        header("Location: index.php?action=login");
        exit();
    }
}
?>