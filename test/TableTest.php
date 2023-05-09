<?php

use MyApp\System\Modules\Migrations\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase{

    public function testGenerateTable() {
        $table = new Table();
        $table->id();
        $table->name('users');
        $table->string('nome');
        $table->decimal('preco');
        
        $query  = "create table IF NOT EXISTS users  (id bigint unsigned auto_increment primary key ,nome varchar(255) ,preco decimal ) ENGINE=InnoDB";
        $this->assertEquals(
            $query,
            trim($table->__toString())
        );
    } 
    
    
    public function testGenerateTableWithOptions() {
        $table = new Table();
        $table->id();
        $table->name('users');
        $table->string('nome');
        $table->decimal('preco');
        
        $query  = "create table IF NOT EXISTS users  (id bigint unsigned auto_increment primary key ,nome varchar(255) ,preco decimal ) ENGINE=InnoDB";
        $this->assertEquals(
            $query,
            trim($table->__toString())
        );
    } 


    function testGenerateTableWithUnique() {
        $table = new Table();
        $table->id();
        $table->name('users');
        $table->string('column')->unique();

        $this->assertEquals(
            $table->__toString(),
            "create table IF NOT EXISTS users  (id bigint unsigned auto_increment primary key ,column varchar(255)  unique ) ENGINE=InnoDB"
        );
    }

}