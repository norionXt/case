#!/bin/bash

# Copia o arquivo .sql para o diretório do container
docker cp config/mysql/init.sql case_mysql:/procedure.sql

# Executa o conteúdo do arquivo .sql no container
docker exec -i case_mysql mysql -uroot -p123 myapp < config/mysql/init.sql


# Adiciona a atividade no cron
echo "0 * * * * /src/System/Modules/Jobs/Jobs.php" >> /etc/crontab

# Reinicia o serviço cron para aplicar as mudanças
service cron restart