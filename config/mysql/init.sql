CREATE DATABASE if not exists myapp;


create table IF NOT EXISTS Usuarios  ( 
    id bigint unsigned auto_increment primary key ,
    nomeCompleto varchar(255),
    email varchar(255) not null unique,
    cpf varchar(255) not null unique,
    cnpj varchar(255),
    senha varchar(255) not null,
    saldo decimal default 200) ENGINE=InnoDB;




DELIMITER //
CREATE PROCEDURE pay(in idPayer bigint, in idPayee bigint, in amount decimal)
BEGIN
DECLARE erro_sql TINYINT DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET erro_sql = TRUE;
START TRANSACTION;
update usuarios set saldo = saldo - amount where id = idPayer;
update usuarios set saldo = saldo + amount where id = idPayee;

  IF erro_sql = FALSE THEN
    COMMIT;
    SELECT 'Transação efetivada com sucesso.' AS Resultado;
  ELSE
    ROLLBACK;
    SELECT 'Erro na transação' AS Resultado;
  END IF;
END//
DELIMITER ;