<?php
/**
 * Created by PhpStorm.
 * User: ariful
 * Date: 2/25/15
 * Time: 1:10 PM
 */

/**
 * Autoloading Test fiels
 *
 */
spl_autoload_register(function ($class) {
    include (__DIR__.'/LRPC/LRPCTest.php');
    //        include 'classes/' . $class . '.class.php';
});

    use AppioLab\Tests\LRPC;


    $test = new LRPC\LRPCTest();


echo PHP_EOL;