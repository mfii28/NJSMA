CREATE DATABASE IF NOT EXISTS njsma;
USE njsma;

CREATE TABLE IF NOT EXISTS mce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS tblcategory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS tblposts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    PostTitle VARCHAR(255),
    CategoryId INT,
    SubCategoryId INT,
    PostDetails TEXT,
    PostingDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PostUrl VARCHAR(255),
    PostImage VARCHAR(255),
    Is_Active INT DEFAULT 1,
    FOREIGN KEY (CategoryId) REFERENCES tblcategory(id)
);

-- Insert sample data
INSERT INTO mce (first_name, last_name) VALUES ('Isaac', 'Appaw-Gyasi');
INSERT INTO tblcategory (CategoryName) VALUES ('News'), ('Events'), ('Announcements');
INSERT INTO tblposts (PostTitle, CategoryId, PostDetails, PostImage, Is_Active) 
VALUES ('Welcome to NJSMA', 1, 'This is our first post on the new platform.', 'slider-1.jpg', 1);
