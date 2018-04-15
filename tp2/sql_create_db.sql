START TRANSACTION;
DROP DATABASE IF EXISTS trabalho_final_ibd;
CREATE DATABASE trabalho_final_ibd;
USE trabalho_final_ibd;

CREATE TABLE artista (
	id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    data_nascimento DATE NULL,
    nacionalidade VARCHAR(50) NULL,
    INDEX(nome)
);

CREATE TABLE banda (
	id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    ano_formacao MEDIUMINT UNSIGNED NULL,
    INDEX(nome)
);

CREATE TABLE toca (
	artista_id BIGINT NOT NULL REFERENCES artista(id) ON DELETE RESTRICT,
    banda_id BIGINT NOT NULL REFERENCES banda(id) ON DELETE RESTRICT,
    instrumento VARCHAR(50) NOT NULL,
    CONSTRAINT UNIQUE toca_uk (artista_id, banda_id),
    INDEX(instrumento)
);

CREATE TABLE interprete (
	id BIGINT AUTO_INCREMENT PRIMARY KEY,
    artista_id BIGINT NULL REFERENCES artista(id) ON DELETE CASCADE,
    banda_id BIGINT NULL REFERENCES banda(id) ON DELETE CASCADE,
    CONSTRAINT artista_ou_banda CHECK (artista_id OR banda_id), -- pelo menos um não é nulo
    CONSTRAINT artista_e_nao_banda CHECK (NOT (artista_id AND banda_id)) -- apenas um não é nulo
);

CREATE TABLE album (
	id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    interprete_id BIGINT NULL REFERENCES interprete(id) ON DELETE RESTRICT, -- interprete NULL significa que há vários no album (coletânea)
    gravadora VARCHAR(255) NULL, -- gravadora NULL significa album independente
    ano MEDIUMINT UNSIGNED NULL,
    INDEX(nome)
);

CREATE TABLE faixa (
	id BIGINT AUTO_INCREMENT PRIMARY KEY,
    album_id BIGINT NOT NULL REFERENCES album(id) ON DELETE CASCADE,
    numero_ordem TINYINT UNSIGNED NOT NULL,
    nome VARCHAR(150) NOT NULL,
    duracao TIME NOT NULL,
    CONSTRAINT UNIQUE faixa_uk (album_id, numero_ordem),
    INDEX(nome)
);

CREATE TABLE genero_faixa (
	faixa_id BIGINT NOT NULL REFERENCES faixa_id ON DELETE CASCADE,
    genero VARCHAR(50) NOT NULL,
    CONSTRAINT UNIQUE genero_faixa_uk (faixa_id, genero)
);

CREATE TABLE interprete_faixa (
	interprete_id BIGINT NOT NULL REFERENCES interprete(id) ON DELETE RESTRICT,
    faixa_id BIGINT NOT NULL REFERENCES faixa(id) ON DELETE RESTRICT,
    CONSTRAINT UNIQUE interprete_faixa_uk (interprete_id, faixa_id)
);
COMMIT;
