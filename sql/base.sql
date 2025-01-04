DROP TABLE IF EXISTS gift_choice;
DROP TABLE IF EXISTS gift_gift;
DROP TABLE IF EXISTS gift_move;
DROP TABLE IF EXISTS gift_categorie;
DROP TABLE IF EXISTS gift_user;

DROP VIEW IF EXISTS gift_user_balance_view;
DROP VIEW IF EXISTS gift_deposits_view;
DROP VIEW IF EXISTS gift_non_accepted_deposits_view;
DROP VIEW IF EXISTS gift_accepted_deposits_view;
DROP VIEW IF EXISTS gift_user_withdrawals_view;
-- ------------------------------
-- View table creation (how many money the users have)
-- ------------------------------

-- Added constraints here
CREATE TABLE gift_user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(20) NOT NULL UNIQUE, 
    password varchar(20) NOT NULL,
    is_admin int NOT NULL DEFAULT 0
);

CREATE TABLE gift_categorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(20)
);

-- Changed depot to move
CREATE TABLE gift_move (
    id_move INT AUTO_INCREMENT PRIMARY KEY,
    id_user int,
    montant decimal(10,2),
    is_accepted INT DEFAULT 0,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255), -- Deposit or Payment
    foreign key(id_user) references gift_user(id_user)
);

CREATE TABLE gift_gift (
    id_gift INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(20),
    id_categorie int,
    montant int,
    description TEXT,
    stock_quantity INT DEFAULT 0,
    pic VARCHAR(255),
    foreign key(id_categorie) references gift_categorie(id_categorie)
);

CREATE TABLE gift_choice (
    id_choice INT AUTO_INCREMENT PRIMARY KEY,
    id_user int,
    id_gift int,
    quantity int, 
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foreign key(id_user) references gift_user(id_user),
    foreign key(id_gift) references gift_gift(id_gift)
);

-- ------------------------------
-- View to Calculate User Balance (how much money the users have)
-- ------------------------------
CREATE VIEW gift_user_balance_view AS
SELECT
    u.id_user, u.name, COALESCE(SUM(m.montant), 0) AS current_balance
FROM
    gift_user u
LEFT JOIN
    gift_move m ON u.id_user = m.id_user
WHERE 
    is_accepted = 1
GROUP BY
    u.id_user;

-- ------------------------------
-- View for Deposits (positive moves), negative ones are withdrawals
-- ------------------------------
CREATE VIEW gift_deposits_view AS
SELECT
    u.id_user, u.name, m.id_move, m.montant,  m.description, m.date, m.is_accepted
FROM
    gift_user u
JOIN
    gift_move m ON u.id_user = m.id_user
WHERE
    m.montant > 0;

CREATE VIEW gift_non_accepted_deposits_view AS
SELECT 
    *
FROM 
    gift_deposits_view
WHERE 
    is_accepted = 0;

CREATE VIEW gift_accepted_deposits_view AS
SELECT 
    *
FROM 
    gift_deposits_view
WHERE 
    is_accepted = 1;

-- Insérer des utilisateurs
INSERT INTO gift_user (name, password, is_admin) VALUES 
('Alice', 'password123', 0),
('Bob', 'securePass', 1),
('Charlie', 'mypassword', 0);

-- Categories are girl, boy and neutral
INSERT INTO gift_categorie (id_categorie, name) VALUES 
(1, 'girl'),
(2, 'boy'),
(3, 'neutral');

-- Insérer des mouvements
INSERT INTO gift_move (id_user, montant, description) VALUES 
(1, 100.00, 'Deposit'),
(2, 250.50, 'Deposit'),
(3, 75.00, 'Deposit');

INSERT INTO gift_gift (name, id_categorie, montant, description, stock_quantity, pic) VALUES
-- Anything gaming related is 3 because gaming is for everyone :)
('PS5 Console', 3, 499.99, 'The latest PlayStation 5 console with advanced features.', 3, 'ps5_console.jpg'),
('PS5 DualSense Controller', 3, 69.99, 'Ergonomic controller with haptic feedback and adaptive triggers.', 5, 'ps5_controller.jpg'),
('PS5 DualSense Charging Station', 3, 39.99, 'Charge up to two DualSense controllers simultaneously.', 4, 'ps5_charging_station.jpg'),
('PS5 Pulse 3D Wireless Headset', 3, 99.99, 'Immersive 3D audio experience for PS5 gaming.', 3, 'ps5_headset.jpg'),
('PS5 Media Remote', 3, 39.99, 'Control your media and streaming on the PS5.', 6, 'ps5_remote.jpg'),
('PS5 HD Camera', 3, 59.99, 'Capture yourself in crystal-clear video for streaming.', 3, 'ps5_camera.jpg'),
('PS5 Game: Spider-Man: Miles Morales', 3, 49.99, 'Action-packed adventure game for PS5.', 8, 'ps5_game_spiderman.jpg'),
('PS5 Game: Demons Souls', 3, 59.99, 'Critically acclaimed RPG rebuilt for PS5.', 5, 'ps5_game_demonsouls.jpg'),
('PS5 Game: Ratchet & Clank: Rift Apart', 3, 59.99, 'Interdimensional action game for PS5.', 4, 'ps5_game_ratchet.jpg'),
('PS5 Game: Horizon Forbidden West', 3, 59.99, 'Epic open-world adventure game.', 6, 'ps5_game_horizon.jpg'),
('PS5 Game: Returnal', 3, 49.99, 'Thrilling roguelike third-person shooter.', 3, 'ps5_game_returnal.jpg'),
('PS5 Vertical Stand', 3, 19.99, 'Stand to position your PS5 vertically.', 7, 'ps5_stand.jpg'),
('PS5 Cooling Fan', 3, 35.99, 'Keep your PS5 cool during intense gaming sessions.', 3, 'ps5_cooling_fan.jpg'),
('PS5 Protective Skin', 3, 14.99, 'Customizable skin to protect your PS5.', 6, 'ps5_skin.jpg'),
('PS5 VR Headset', 3, 399.99, 'Immersive virtual reality gaming experience.', 1, 'ps5_vr.jpg'),
('PS5 Game: Ghost of Tsushima: Director’s Cut', 3, 59.99, 'Enhanced samurai adventure game.', 4, 'ps5_game_ghost.jpg'),
('PS5 External Storage Drive', 3, 99.99, 'Expand your PS5 storage capacity.', 3, 'ps5_storage.jpg'),
('PS5 Game: Gran Turismo 7', 3, 59.99, 'Realistic racing simulator for PS5.', 5, 'ps5_game_gt7.jpg'),
('PS5 Game: Resident Evil Village', 3, 49.99, 'Survival horror masterpiece.', 4, 'ps5_game_re8.jpg'),
('PS5 Light-Up Display Stand', 3, 34.99, 'Stylish stand with LED lights for PS5.', 7, 'ps5_display_stand.jpg'),

-- Books
('Storybook 1', 1, 15.99, 'A captivating storybook for young readers.', 5, 'book1.jpg'),
('Storybook 2', 1, 14.50, 'An exciting sequel to the favorite tale.', 7, 'book2.jpg'),
('Puzzle Book 1', 3, 12.75, 'A fun book filled with puzzles and riddles.', 6, 'book3.jpg'),
('Coloring Book 1', 1, 10.99, 'Creative coloring fun for kids.', 4, 'book4.jpg'),
('Book Set 1', 1, 50.00, 'A set of classic books.', 8, 'book5.jpg'),
('Book Set 2', 1, 45.00, 'A bundle of adventure novels.', 5, 'book6.jpg'),

-- Toy Cars
('Toy Cars 1', 2, 15.99, 'Miniature toys car for kids.', 4, 'car1.jpg'),
('Remote Car 1', 2, 45.99, 'Remote-controlled racing car.', 3, 'car2.jpg'),
('Remote Car 2', 2, 55.00, 'Advanced remote-controlled car.', 5, 'car3.jpg'),
('Toy Car 2', 2, 20.00, 'Pull-back toy car.', 6, 'car4.jpg'),
('Race Car 1', 2, 90.00, 'Advanced RC race car.', 3, 'car5.jpg'),
('Race Car 2', 2, 100.00, 'High-speed RC race car.', 1, 'car6.jpg'),

-- Plush Toys
('Plush Toy 1', 1, 20.00, 'Soft and cuddly plush toy.', 7, 'toy1.jpg'),
('Plush Toy 2', 1, 25.50, 'Adorable animal plush toy.', 3, 'toy2.jpg'),

-- Art Kits
('Art Kit 1', 1, 40.00, 'Comprehensive art set for creative minds.', 9, 'art1.jpg'),
('Art Kit 2', 1, 30.00, 'Basic art kit for beginners.', 6, 'art2.jpg'),

-- Helmets
('Bike Helmet 1', 3, 25.00, 'Safety helmet for biking.', 10, 'helmet1.jpg'),
('Bike Helmet 2', 3, 30.00, 'Stylish helmet with advanced protection.', 7, 'helmet2.jpg'),

-- Balls
('Soccer Ball 1', 3, 20.00, 'Standard size soccer ball.', 8, 'ball1.jpg'),
('Soccer Ball 2', 3, 25.00, 'High-quality soccer ball.', 7, 'ball2.jpg'),
('Basketball 1', 3, 30.00, 'Professional basketball.', 4, 'ball3.jpg'),
('Basketball 2', 3, 35.00, 'Indoor-outdoor basketball.', 6, 'ball4.jpg'),

-- Lego Sets
('Lego Set 1', 2, 60.00, 'Building blocks for creative play.', 8, 'lego1.jpg'),
('Lego Set 2', 2, 75.00, 'Advanced Lego set for older kids.', 4, 'lego2.jpg'),

-- Magic Kits
('Magic Kit 1', 1, 20.00, 'Beginner’s magic trick kit.', 8, 'magic1.jpg'),
('Magic Kit 2', 1, 35.00, 'Professional magic trick kit.', 4, 'magic2.jpg'),

-- Scooters
('Scooter 1', 3, 85.00, 'Fun outdoor scooter.', 6, 'scooter1.jpg'),
('Scooter 2', 3, 95.00, 'Electric scooter for kids.', 2, 'scooter2.jpg'),

-- Robots
('Toy Robot 1', 2, 65.00, 'Interactive robot toy.', 1, 'robot1.jpg'),
('Toy Robot 2', 2, 70.00, 'Programmable robot for kids.', 3, 'robot2.jpg'),

-- Drones
('Drone 1', 2, 120.00, 'Mini drone for beginners.', 3, 'drone1.jpg'),
('Drone 2', 2, 150.00, 'Advanced camera drone.', 2, 'drone2.jpg');