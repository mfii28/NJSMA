USE njsma;

-- 1. Management Table
CREATE TABLE IF NOT EXISTS tblmanagement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(255) NOT NULL,
    Position VARCHAR(255) NOT NULL,
    Image VARCHAR(255),
    Bio TEXT,
    Rank INT DEFAULT 0 -- For ordering (0, 1, 2...)
);

-- 2. Assembly Members Table
CREATE TABLE IF NOT EXISTS tblassembly_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(255) NOT NULL,
    ElectoralArea VARCHAR(255),
    Position VARCHAR(255) DEFAULT 'Elected Member', -- Elected vs Appointee
    Image VARCHAR(255)
);

-- Seed Management Data (from live site info)
INSERT INTO tblmanagement (FullName, Position, Image, Rank) VALUES 
('Edward Abazing', 'Municipal Co-ordinating Director', 'management-1.jpg', 1),
('Tharzia Akwetey', 'Head, Department of Agriculture', 'management-2.jpg', 2),
('Alhassan Muntala', 'Head, Finance Department', 'management-3.jpg', 3),
('Iris Dalaba', 'Head, Planning Department', 'management-4.jpg', 4),
('Christian Tetteh', 'Head, Physical Planning Department', 'management-5.jpg', 5),
('Josephine Dzokoto', 'Head, Social Welfare Department', 'management-6.jpg', 6),
('Mary Labi', 'Head, Human Resource Department', 'management-7.jpg', 7);

-- Seed Assembly Members Data (Sample)
INSERT INTO tblassembly_members (FullName, ElectoralArea, Position) VALUES 
('Hon. Kofi Mensah', 'Nsukwao', 'Elected Member'),
('Hon. Ama Serwaa', 'Betom', 'Elected Member'),
('Hon. John Owusu', 'Government Appointee', 'Appointee');
