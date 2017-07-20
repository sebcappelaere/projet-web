<?php

use RedBeanPHP\R as R;

R::setup(
    "mysql:host=localhost;dbname=formation_sql;charset=utf8",
    "root",
    "1234"
    );

//Destruction des tables de la base de données
//R::trashAll("country");
//R::trashAll("beers");


$countries = [
    'fr' => R::dispense('country')->import(['country' => 'France']),
    'ie' => R::dispense('country')->import(['country' => 'Irlande'])
];

$beer = R::dispense('beers');
$beer->name = "Guiness";
$beer->color = "noire";
$beer->country = $countries["ie"];
$beer->strength = 4.2;
$beer->rating = 4;
R::store($beer);

$beer = R::dispense('beers');
$beer->name = "Moulins d'Ascq";
$beer->color = "blonde";
$beer->country = $countries["fr"];
$beer->strength = 6;
$beer->rating = 5;
R::store($beer);

var_dump(R::findAll("beers"));