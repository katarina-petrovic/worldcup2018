<?php
/*
 *  This is page that display all teams with statistics 
 *  
 */
include 'Model\Team.php';

$team = new Team();
echo $team->display_teams_json();

