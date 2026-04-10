USE njsma;

-- 1. Documents Table
CREATE TABLE IF NOT EXISTS tbldocuments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Description TEXT,
    FilePath VARCHAR(255) NOT NULL,
    Category VARCHAR(100),
    UploadDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tenders Table
CREATE TABLE IF NOT EXISTS tbltenders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ReferenceNo VARCHAR(100),
    Title VARCHAR(255) NOT NULL,
    Description TEXT,
    Deadline DATE,
    Status ENUM('Open', 'Closed') DEFAULT 'Open',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Departments Table
CREATE TABLE IF NOT EXISTS tbldepartments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    DeptName VARCHAR(255) NOT NULL,
    Description TEXT,
    HeadName VARCHAR(255),
    HeadImage VARCHAR(255),
    Icon VARCHAR(50)
);

-- 4. Gallery Table
CREATE TABLE IF NOT EXISTS tblgallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Description TEXT,
    ThumbImage VARCHAR(255),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Gallery Images Table
CREATE TABLE IF NOT EXISTS tblgallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    GalleryId INT,
    ImagePath VARCHAR(255),
    FOREIGN KEY (GalleryId) REFERENCES tblgallery(id) ON DELETE CASCADE
);

-- Seed Data for Departments
INSERT INTO tbldepartments (DeptName, Description, HeadName, Icon) VALUES 
('Central Administration', 'Ensuring implementation of governmental policies at the MMDA level.', 'Ahmed Rufai Ibrahim(PhD)', 'bi-building'),
('Human Resource', 'Managing staff development and administrative efficiency.', 'John Doe', 'bi-people'),
('Social Welfare', 'Community development and social security services.', 'Jane Smith', 'bi-heart'),
('Works Department', 'Physical infrastructure and municipal works.', 'Isaac Boateng', 'bi-hammer');

-- Seed Data for Documents
INSERT INTO tbldocuments (Title, Category, Description, FilePath) VALUES
('Building Permit Form', 'Forms', 'Official application form for building permits.', 'docs/building_permit.pdf'),
('2024 Bye-Laws', 'Legal', 'General assembly bye-laws for the current year.', 'docs/bye_laws_2024.pdf'),
('Client Service Charter', 'Reports', 'Our commitment to quality service delivery.', 'docs/charter.pdf');
