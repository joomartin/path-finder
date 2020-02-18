<?php

require __DIR__ . '/vendor/autoload.php';

use PathFinder\PathFinder;

$pf = new PathFinder;

$pf
    ->here('Users/joomartin')
    ->goto('code')
    ->goto('path-finder')
    ->goto('some')
    ->goto('dir')
    ->mix('path-finder', '/Users/user/path-finder');
    // ->createRecursive();
echo $pf;
// var_dump($pf->getFirst());
// var_dump($pf->getLast());