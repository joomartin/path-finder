<?php

require __DIR__ . '/vendor/autoload.php';

use PathFinder\PathFinder;

$pf = new PathFinder;

$pwd = $pf
    ->cd('/Users/joomartin')
    ->cd('code')
    ->cd('path-finder')
    ->cd('some')
    ->cd('dir')
    ->mix('path-finder', '/Users/joomartin/path-finder')
    ->cd('/Applications/MAMP')
    // ->mkdir()
    ->pwd();
var_dump($pwd);
var_dump($pf->first());
var_dump($pf->last());