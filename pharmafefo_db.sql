-- Création de la base de données
CREATE DATABASE IF NOT EXISTS pharmafefo;
USE pharmafefo;

-- 1. Table USERS (Utilisateurs)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('PREPARATEUR', 'PHARMACIEN', 'ADMINISTRATEUR') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Table PRODUCTS (Médicaments)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cip_code VARCHAR(50) NOT NULL UNIQUE,
    designation VARCHAR(150) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    min_stock_alert INT DEFAULT 10,
    unit VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Table BATCHES (Lots de Stock)
CREATE TABLE batches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    batch_number VARCHAR(50) NOT NULL,
    expiration_date DATE NOT NULL,
    qty_received INT NOT NULL,
    qty_available INT NOT NULL,
    status ENUM('ACTIVE', 'EXPIRED', 'RETURNED', 'DESTROYED') DEFAULT 'ACTIVE',
    CONSTRAINT fk_batch_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Table STOCK_MOVEMENTS (Traçabilité des mouvements)
CREATE TABLE stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('ENTRY', 'EXIT', 'RETURN', 'DESTRUCTION') NOT NULL,
    quantity INT NOT NULL,
    movement_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    note TEXT,
    CONSTRAINT fk_movement_batch FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE,
    CONSTRAINT fk_movement_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Table NOTIFICATIONS (Alertes de péremption)
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    message TEXT NOT NULL,
    level ENUM('GREEN', 'ORANGE', 'RED') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    CONSTRAINT fk_notification_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- JEU DE DONNÉES DE TEST (POUR COMMENCER DIRECTEMENT)
-- =========================================================

-- Insertion d'un Administrateur par défaut (Mot de passe: admin123)
-- NB: Le mot de passe ici est hashé avec BCRYPT pour PHP (password_hash)
INSERT INTO users (name, email, password, role) 
VALUES ('Admin Pharma', 'admin@pharmafefo.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMINISTRATEUR');

-- Insertion de quelques produits
INSERT INTO products (cip_code, designation, price, min_stock_alert, unit) VALUES 
('CIP-1001', 'Doliprane 1000mg', 15.50, 20, 'Boîte'),
('CIP-1002', 'Amoxicilline 500mg', 35.00, 15, 'Boîte'),
('CIP-1003', 'Spasfon', 22.00, 10, 'Boîte');

-- Insertion de lots avec différentes dates de péremption pour tester le Dashboard
INSERT INTO batches (product_id, batch_number, expiration_date, qty_received, qty_available, status) VALUES 
(1, 'LOT-8475', DATE_ADD(CURDATE(), INTERVAL 15 DAY), 50, 20, 'ACTIVE'), -- Alerte Rouge (< 30 jrs)
(2, 'LOT-1120', DATE_ADD(CURDATE(), INTERVAL 60 DAY), 100, 80, 'ACTIVE'), -- Alerte Orange (< 90 jrs)
(3, 'LOT-9988', DATE_ADD(CURDATE(), INTERVAL 200 DAY), 40, 40, 'ACTIVE'); -- Alerte Verte (> 6 mois)