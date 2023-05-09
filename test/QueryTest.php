<?php

use MyApp\System\Modules\Modal\Query;
use PHPUnit\Framework\TestCase;

final class QueryTest extends TestCase{

    function testQuerySelect() {
        $queryPrepared = (new Query())->table('user')->select(['name','sobrenome']);
        $this->assertEquals($queryPrepared, "select name,sobrenome from user ");
    }

    function testQuerySelectWithWhere() {
        $queryPrepared = (new Query())
        ->table('user')
        ->where('id','=')
        ->select(['name','sobrenome']);
        $this->assertEquals(trim($queryPrepared), "select name,sobrenome from user  where id=:id");
    }

    function testQuerySelectWithDoubleWhere() {
        $queryPrepared = (new Query())
        ->table('user')
        ->where('id','=','or')
        ->where('name','=')
        ->select(['name','sobrenome']);
        $this->assertEquals(trim($queryPrepared), "select name,sobrenome from user  where id=:id or name=:name");
    }    

    function testQueryUpdate() {
        $queryPrepared = (new Query())->table('user')->update(['name','sobrenome']);
        $this->assertEquals(trim($queryPrepared), "update user set name=:name,sobrenome=:sobrenome,date_updated=now() where");
    }


    function testQueryUpdateWithWhere() {
        $queryPrepared = (new Query())
        ->table('user')
        ->where('name', '=')
        ->update(['name','sobrenome']);
        $this->assertEquals(
            trim($queryPrepared),
            "update user set name=:name,sobrenome=:sobrenome,date_updated=now() where name=:name"
        );
    }



}