<?php

namespace MyApp\Migrations;

use MyApp\System\Interfaces\IMigrations;
use MyApp\System\Interfaces\ITable;

class Jobs implements IMigrations{

    public function up(ITable $table): ITable {

        $table->id();
        $table->name('class');
        $table->string('method')->notNull();
        $table->string('params');
        $table->string('status');        
        return $table;
    } 
}