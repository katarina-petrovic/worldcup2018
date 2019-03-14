<?php

/*
 *  This is page delete all data from database 
 *  
 */

include 'Model/Team.php';
include 'Model/Match.php';

$team = new Team();
$match = new Match();
if($team->delete() && $match->delete()) {
    echo "Database is empty";
} else {
    echo "Something's wrong.. Database is not empty";
}