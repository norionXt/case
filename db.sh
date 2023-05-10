#!/bin/bash

# Copia o arquivo .sql para o diretório do container
docker cp config/mysql/init.sql case_db_1:/procedure.sql

# Executa o conteúdo do arquivo .sql no container
docker exec -i case_db_1 mysql -uroot -p123 myapp < config/mysql/init.sql
