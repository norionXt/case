CREATE DATABASE if not exists myapp;


create table IF NOT EXISTS Usuarios  ( 
    id bigint unsigned auto_increment primary key ,
    nomeCompleto varchar(255) not null,
    email varchar(255) not null unique,
    cpf varchar(255) not null unique,
    cnpj varchar(255),
    senha varchar(255) not null,
    saldo decimal default 200) ENGINE=InnoDB;


create table IF NOT EXISTS Jobs  ( 
    id bigint unsigned auto_increment primary key ,
    class varchar(255),
    method varchar(255) not null,
    params varchar(255),
    status varchar(255) default 0,
    expect varchar(255)
    );    




DELIMITER //
CREATE PROCEDURE pay(in idPayer bigint, in idPayee bigint, in amount decimal)
BEGIN
DECLARE erro_sql TINYINT DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET erro_sql = TRUE;
START TRANSACTION;
update Usuarios set saldo = saldo - amount where id = idPayer;
update Usuarios set saldo = saldo + amount where id = idPayee;

  IF erro_sql = FALSE THEN
    COMMIT;
    SELECT 'Transação efetivada com sucesso.' AS Resultado;
  ELSE
    ROLLBACK;
    SELECT 'Erro na transação' AS Resultado;
  END IF;
END//
DELIMITER ;