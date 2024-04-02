-- Tabela 'subcontas'
CREATE TABLE subconta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    document VARCHAR(255) NOT NULL,
    nameDisplay VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    emailContact VARCHAR(255) NOT NULL,
    logo TEXT,
    responsibleDocument VARCHAR(255) NOT NULL,
    typeCompany VARCHAR(50) NOT NULL,
    softDescriptor VARCHAR(255) NOT NULL,
    cnae VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela 'addresses'
CREATE TABLE subconta_endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subconta_id INT,
    zipCode VARCHAR(20) NOT NULL,
    street VARCHAR(255) NOT NULL,
    number VARCHAR(20) NOT NULL,
    complement VARCHAR(255),
    neighborhood VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subconta_id) REFERENCES subconta (id)
);

-- Tabela 'professionals'
CREATE TABLE subconta_profissional (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subconta_id INT,
    internalName VARCHAR(255) NOT NULL,
    inscription VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subconta_id) REFERENCES subconta(id)
);


ALTER TABLE subconta ADD COLUMN galaxPayId INT;
ALTER TABLE subconta ADD COLUMN galaxId VARCHAR(255);
ALTER TABLE subconta ADD COLUMN galaxHash VARCHAR(255);