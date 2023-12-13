CREATE TABLE cadastro_contabancaria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    document VARCHAR(20) NOT NULL,
    name_display VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email_contact VARCHAR(255) NOT NULL,
    responsible_document VARCHAR(20) NOT NULL,
    type_company ENUM('ltda', 'eireli', 'association', 'individualEntrepreneur', 'mei', 'sa', 'slu') NOT NULL,
    soft_descriptor VARCHAR(255) NOT NULL,
    cnae VARCHAR(255) NOT NULL,
    
    zipcode VARCHAR(20) NOT NULL,
    street VARCHAR(255) NOT NULL,
    number VARCHAR(20) NOT NULL,
    complement VARCHAR(255),
    neighborhood VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);