CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    sex VARCHAR(10) NOT NULL,
    country VARCHAR(50),
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, 
    address TEXT,
    department VARCHAR(100),
    skills JSON, 
    profilePath VARCHAR(255),
    role VARCHAR(20) NOT NULL DEFAULT "user"
);