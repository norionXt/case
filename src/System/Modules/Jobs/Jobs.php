<?php

namespace MyApp\System\Modules\Jobs;

use MyApp\Model\Jobs;

require "../../../../vendor/autoload.php";


    $jobs  = new Jobs();
    $listJobs =  $jobs->where('status','=', '0')->select(['*']);

    foreach ($listJobs as $job) {
        $class = unserialize($job['class']);
        $value = $class->{$job['method']}($job['params']);
        if($value == $job['expect']) {
            $jobs->query(
                'update Jobs set expect = :expect where id = :id',
                [':id' => $job['id'],':expect' => 1]
            );
        }
    }