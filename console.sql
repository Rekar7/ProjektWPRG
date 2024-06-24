-- Tabela ról użytkowników
CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
);

-- Tabela użytkowników
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone_number VARCHAR(50) NOT NULL,
    address VARCHAR(300) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- Tabela kategorii mebli
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

-- Tabela produktów
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category_id INT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    image VARCHAR(100) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Tabela zamówień
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date DATETIME NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Tabela pozycji zamówień
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Dodanie przykładowych danych

-- Dodanie ról użytkowników
INSERT INTO roles (role_name) VALUES ('user'), ('employee'), ('administrator');

-- Dodanie przykładowego użytkownika
INSERT INTO users (name, last_name, phone_number, password, address, email, role_id) VALUES
('john', 'doe', '123456789', '123', 'Sianów Koszalińska 15','john@example.com', 1),
('jane', 'doe', '333222111', '123', 'Biesiekierz Ziemniaczana 3','jane@example.com', 3);

-- Dodanie kategorii mebli
INSERT INTO categories (category_name) VALUES
('Salon'),
('Sypialnia'),
('Biuro'),
('Jadalnia'),
('Kuchnia'),
('Na zewnątrz'),
('Łazienka'),
('Dzieci'),
('Dekoracje'),
('Przechowywanie'),
('Przedpokój'),
('Oświetlenie'),
('Materace');

-- Dodanie produktów
INSERT INTO products (product_name, category_id, price, stock_quantity, image) VALUES
('Sofa', 1, 499.99, 10, 'zdjecie1.jpg'),
('Łóżko', 2, 299.99, 5, 'zdjecie2.jpg'),
('Krzesło biurowe', 3, 89.99, 15, 'zdjecie3.jpg'),
('Stół jadalniany', 4, 199.99, 8, 'zdjecie4.jpg'),
('Szafka kuchenna', 5, 249.99, 12, 'zdjecie5.jpg'),
('Zestaw ogrodowy', 6, 399.99, 4, 'zdjecie6.jpg'),
('Szafka łazienkowa', 7, 299.99, 6, 'zdjecie7.jpg'),
('Łóżko dziecięce', 8, 199.99, 7, 'zdjecie8.jpg'),
('Obraz na ścianę', 9, 49.99, 20, 'zdjecie9.jpg'),
('Regał na książki', 10, 89.99, 14, 'zdjecie10.jpg'),
('Ławka do przedpokoju', 11, 129.99, 9, 'zdjecie11.jpg'),
('Lampa stojąca', 12, 59.99, 11, 'zdjecie12.jpg'),
('Materac queen', 13, 399.99, 10, 'zdjecie13.jpg'),
('Fotel', 1, 299.99, 8, 'zdjecie14.jpg'),
('Komoda', 2, 399.99, 5, 'zdjecie15.jpg'),
('Biurko', 3, 199.99, 7, 'zdjecie16.jpg'),
('Krzesło jadalniane', 4, 79.99, 20, 'zdjecie17.jpg'),
('Stół kuchenny', 5, 179.99, 10, 'zdjecie18.jpg'),
('Huśtawka ogrodowa', 6, 199.99, 5, 'zdjecie19.jpg'),
('Lustro łazienkowe', 7, 99.99, 12, 'zdjecie20.jpg'),
('Szafa dziecięca', 8, 249.99, 6, 'zdjecie21.jpg'),
('Wazon', 9, 29.99, 30, 'zdjecie22.jpg'),
('Szafa przesuwna', 10, 499.99, 4, 'zdjecie23.jpg'),
('Wieszak na ubrania', 11, 49.99, 15, 'zdjecie24.jpg'),
('Lampa sufitowa', 12, 89.99, 10, 'zdjecie25.jpg'),
('Materac dziecięcy', 13, 199.99, 8, 'zdjecie26.jpg');

-- Dodanie przykładowego zamówienia
INSERT INTO orders (user_id, order_date, total_price) VALUES (1, NOW(), 1289.94);

-- Dodanie pozycji zamówienia
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 499.99),
(1, 3, 1, 89.99),
(1, 6, 1, 399.99),
(1, 13, 1, 299.99);

SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                FROM products p
                JOIN order_items oi on p.product_id = oi.product_id
                JOIN categories c ON p.category_id = c.category_id
                WHERE oi.order_id=3;