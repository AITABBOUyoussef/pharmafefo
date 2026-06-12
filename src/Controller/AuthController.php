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

            $user = $userRepo->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role']; // Matalan: 'PHARMACIEN' wla 'PREPARATEUR'

                 header("Location: index.php?action=dashboard");
                exit();
            } else {
                 header("Location: index.php?action=login&error=invalid_credentials");
                exit();
            }
        }
    }

     public function logout() {
        session_start();
        session_unset(); 
        session_destroy(); 
        header("Location: index.php?action=login");
        exit();
    }
}
?>