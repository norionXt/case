<?php

namespace MyApp\System\Interfaces;

interface IMigrations {
    public function up(ITable $table): ITable;
}