<?php

namespace MyApp\Migrations;

use MyApp\System\Interfaces\IMigrations;
use MyApp\System\Interfaces\ITable;
use MyApp\System\Modules\Migrations\Table;

class usuarios implements IMigrations{


    public function up(ITable $table): ITable {
        $table->id();
        $table->name('usuarios');
        $table->string('nomeCompleto')->notNull();
        $table->string('cpf')->unique();
        $table->string('cnpj')->unique();        
        $table->string('email')->notNull()->unique();
        $table->string('senha')->notNull();        
        $table->decimal('saldo')->default(200);
        return $table;
    } 
}