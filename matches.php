<?php

/*
 *  This is page that display all matches with statistics 
 *  
 */

/*
 * include classes
 *  
 */

include 'Datafile.php';
include 'Model/Team.php';
include 'Model/Match.php';
include 'Model/MatchTeam.php';
include 'Model/Statistic.php';
include 'Model/Weather.php';
include 'Model/Event.php';
include 'Model/Player.php';

$all_data = array();
$data_match = array();
$matches = new Match();

// get all matches
$all_matches = $matches->display_matches();

foreach ($all_matches as $key_match => $value_match) {

    // data from match and weather table 
    $data_match['venue'] = $value_match->venue;
    $data_match['location'] = $value_match->location;
    $data_match['status'] = $value_match->status;
    $data_match['time'] = $value_match->time;
    $data_match['fifa_id'] = $value_match->fifa_id;
    $data_match['weather']['humidity'] = (int) $value_match->humidity;
    $data_match['weather']['temp_celsius'] = (int) $value_match->temp_celsius;
    $data_match['weather']['temp_farenheit'] = (int) $value_match->temp_farenheit;
    $data_match['weather']['wind_speed'] = (int) $value_match->wind_speed;
    $data_match['weather']['description'] = $value_match->description;
    $data_match['attendance'] = (int) $value_match->attendance;
    $data_match['officials'] = json_decode($value_match->officials);

    // data from match_teams table
    $match_team = new MatchTeam();
    $match_teams = $match_team->display_match_teams($value_match->fifa_id);

    $data_match['home_team_country'] = $match_teams[1]['country'];
    $data_match['away_team_country'] = $match_teams[0]['country'];
    $data_match['datetime'] = $value_match->datetime;
    $data_match['winner'] = $value_match->winner;
    $data_match['winner_code'] = $value_match->winner_code;
    $data_match['home_team'] = $match_teams[1];
    $data_match['away_team'] = $match_teams[0];

    // data from events table
    $match_event = new Event();
    $match_events = $match_event->display_events($value_match->fifa_id);
    $data_match['home_team_events'] = $match_events[1];
    $data_match['away_team_events'] = $match_events[0];

    // data from match_statisctics table
    $match_statistic = new Statistic();
    $all_statistics = $match_statistic->display_match_statistics($value_match->fifa_id);
    $all_statistics[1]['country'] = $match_teams[1]['country'];
    $data_match['home_team_statistics'] = $all_statistics[1];
    $player = new Player();
    $players = $player->display_players($value_match->fifa_id);
    $data_match['home_team_statistics']['starting_eleven'] = $players[$data_match['home_team']['code']][1];
    $data_match['home_team_statistics']['substitutes'] = $players[$data_match['home_team']['code']][0];

    $all_statistics[0]['country'] = $match_teams[0]['country'];
    $data_match['away_team_statistics'] = $all_statistics[0];

    // data from players table
    $player = new Player();
    $players = $player->display_players($value_match->fifa_id);
    $data_match['away_team_statistics']['starting_eleven'] = $players[$data_match['away_team']['code']][1];
    $data_match['away_team_statistics']['substitutes'] = $players[$data_match['away_team']['code']][0];

    $data_match['last_event_update_at'] = $value_match->last_event_update_at;
    $data_match['last_score_update_at'] = $value_match->last_score_update_at;

    $all_data[] = $data_match;
}

// display all data as json format
echo '<pre style="word-wrap: break-word; white-space: pre-wrap;">' . json_encode($all_data) . '</pre>';

