<?php
// for more info see:
// https://github.com/FriendsOfPHP/PHP-CS-Fixer#usage
// https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/UPGRADE.md

if (class_exists('PhpCsFixer\Finder')) {    // PHP-CS-Fixer 2.x
    $finder = PhpCsFixer\Finder::create()
        ->in('src')
        ->in('test')
        ->notPath('temp')
    ;

    return PhpCsFixer\Config::create()
        ->setFinder($finder)
    ;
} elseif (class_exists('Symfony\CS\Finder\DefaultFinder')) {  // PHP-CS-Fixer 1.x
    $finder = Symfony\CS\Finder\DefaultFinder::create()
        ->in('src')
        ->in('test')
        ->notPath('temp')
    ;

    return Symfony\CS\Config\Config::create()
        ->finder($finder)
    ;
}
