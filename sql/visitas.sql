CREATE TABLE imovel(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_proprietario VARCHAR(250) NOT NULL,
    cpf_proprietario VARCHAR(25) NOT NULL,
    email_proprietario VARCHAR(200) NOT NULL,
    zipCode VARCHAR(20) NOT NULL,
    street VARCHAR(255) NOT NULL,
    number VARCHAR(20) NOT NULL,
    complement VARCHAR(255),
    neighborhood VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE imovel_visita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imovel_id INT,
    data_visita DATETIME NOT NULL,
    status VARCHAR(15),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (imovel_id) REFERENCES imovel (id)
);

CREATE TABLE visita_comprador(
    id INT AUTO_INCREMENT PRIMARY KEY,
    visita_id INT,
    nome VARCHAR(250) NOT NULL,
    cpf VARCHAR(25) NULL,
    rg VARCHAR(25) NULL,
    email VARCHAR(200) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (visita_id) REFERENCES imovel_visita (id)
);


ALTER TABLE imovel ADD COLUMN codigo_imovel VARCHAR(100) AFTER id;
ALTER TABLE imovel ADD COLUMN descricao VARCHAR(400) AFTER email_proprietario;
ALTER TABLE imovel MODIFY COLUMN email_proprietario VARCHAR(200) NOT NULL;