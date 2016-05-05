<?php

/*  
 *  Abdeselam El-Haman  et  Cédric Simar
 *  INFO-H-303 : Bases de données - Projet Horeca (partie 2)
 * 
 *  PHP principal pour créer base de données avec toutes les
 *	informations stockées dans les XML
 *
 * -> à proteger avec mdp
 * -> requetes affichées, à changer?
*/

// fichier avec les fonctions d'insertion
include("./insert.php");

function insertAll($database, $etablissement){
	insert_users($database, $etablissement);
	insert_comments($database, $etablissement);
	insert_etabl($database, $etablissement);
	insert_fermeture($database, $etablissement);
	insert_tags($database, $etablissement);
}

$unparsedResto = file_get_contents('./data/Restaurants.xml');
$restXML = new SimpleXMLElement($unparsedResto);
$restaurants = $restXML->xpath("/Restaurants/Restaurant");

$unparsedCafe = file_get_contents('./data/Cafes.xml');
$cafeXML = new SimpleXMLElement($unparsedCafe);
$cafes = $cafeXML->xpath("/Cafes/Cafe");

// localhost et données à changer si jamais

// réation de database pour commencer de 0
// en cas où la db est pas faite (à changer stv)

$connexion = new mysqli("localhost","root","");
$connexion->query("CREATE DATABASE horecafinder;");
$connexion->close();


$database = new mysqli("localhost","root","","horecafinder"); 
createTables($database);


// requetes se font dans chaque fonction
insertAll($database,$restaurants);
insertAll($database,$cafes);
insert_restos($database,$restaurants);
insert_bars($database,$cafes);

$database->close();

?>