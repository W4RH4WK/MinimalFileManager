#!/usr/bin/php
<?php

// usage
if ($argc != 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    echo 'Usage: '.$argv[0]." <user>\n";
    exit(0);
}

// set user
$user = $argv[1];

// passwd
$path = __DIR__.'/../data/passwd.json';
$users = json_decode(file_get_contents($path), true);

// prompt for password
echo 'new password: ';
$pass = trim(fgets(STDIN));

// generate hash
require_once __DIR__.'/../app/helper.php';
$salt = generate_salt();
$hash = generate_hash($pass, $salt);

// add
if (!array_key_exists($user, $users))
    $users[$user] = array();

$users[$user]['hash'] = $hash;
$users[$user]['salt'] = $salt;

// save
file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT));
