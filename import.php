<?php
/*
 *  This is page that collect all data from two json files and import it in database
 *  
 */
set_time_limit(0);

/*
 * include all classes
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

// read json file from url
$filename = "http://worldcup.sfg.io/teams/";
$datafile = new Datafile();
$all_teams = $datafile->read_file($filename);

// get all teams data and import in Teams table 
foreach ($all_teams as $key => $team_attr) {
    $team = new Team();
    $team->set_team_id($team->escape($team_attr['id']));
    $team->set_country($team->escape($team_attr['country']));
    $team->set_alternate_name($team->escape($team_attr['alternate_name']));
    $team->set_fifa_code($team->escape($team_attr['fifa_code']));
    $team->set_group_id($team->escape($team_attr['group_id']));
    $team->set_group_letter($team->escape($team_attr['group_letter']));

    if (!$team->import_team()) {
        die("Something went wrong with Teams import..");
    } 
}

echo "Teams import finished..<br>";

// read json file from url
$filename_matches = "http://worldcup.sfg.io/matches";
$datafile_matches = new Datafile();
$all_matches_file = $datafile_matches->read_file($filename_matches);

$all_match_teams = array();
$all_events = array();
$all_weather = array();
$all_players = array();
$all_matches = array();
$all_statistics = array();

// get all match data and import in database in corresponding table
foreach ($all_matches_file as $match_key => $match_attr) {
    
    // check if match already exists and compare date in database with date in file
    // if date in file is newer than update date field in tables Match, update match_teams table, match_statistics table and event table
    $match = new Match();
    $match->set_last_event_update_at($match_attr['last_event_update_at']);
    $match->set_last_score_update_at($match_attr['last_score_update_at']);
    $match->set_fifa_id($match_attr['fifa_id']);

    $mth = "";
    $mta = "";
    if ($match->match_to_update()) {
        if ($match->match_score_update()) {
            $match->update_score_time();
            $match_team_home = new MatchTeam();
            $match_team_home->set_goals($match_attr['home_team']['goals']);
            $match_team_home->set_penalties($match_attr['home_team']['penalties']);
            $match_team_home->set_code($match_attr['home_team']['code']);
            $mth = $match_team_home->get_code();
            $match_team_home->set_match_id($match->get_fifa_id());
            $match_team_home->set_home_team(1);
            $match_team_home->update_match_team();

            $match_team_away = new MatchTeam();
            $match_team_away->set_goals($match_attr['away_team']['goals']);
            $match_team_away->set_penalties($match_attr['away_team']['penalties']);
            $match_team_away->set_code($match_attr['home_team']['code']);
            $mta = $match_team_away->get_code();
            $match_team_away->set_match_id($match->get_fifa_id());
            $match_team_away->set_home_team(0);
            $match_team_away->update_match_team();

            $statistic_home = new Statistic();
            $statistic_home->set_match_id($match->get_fifa_id());
            $statistic_home->delete_statistics();

            $statistic_home->set_team_code($match_team_home->get_code());
            $statistic_home->set_attempts_on_goal($match_attr['home_team_statistics']['attempts_on_goal']);
            $statistic_home->set_on_target($match_attr['home_team_statistics']['on_target']);
            $statistic_home->set_off_target($match_attr['home_team_statistics']['off_target']);
            $statistic_home->set_blocked($match_attr['home_team_statistics']['blocked']);
            $statistic_home->set_woodwork($match_attr['home_team_statistics']['woodwork']);
            $statistic_home->set_corners($match_attr['home_team_statistics']['corners']);
            $statistic_home->set_offsides($match_attr['home_team_statistics']['offsides']);
            $statistic_home->set_ball_possession($match_attr['home_team_statistics']['ball_possession']);
            $statistic_home->set_pass_accuracy($match_attr['home_team_statistics']['pass_accuracy']);
            $statistic_home->set_num_passes($match_attr['home_team_statistics']['num_passes']);
            $statistic_home->set_passes_completed($match_attr['home_team_statistics']['passes_completed']);
            $statistic_home->set_distance_covered($match_attr['home_team_statistics']['distance_covered']);
            $statistic_home->set_balls_recovered($match_attr['home_team_statistics']['balls_recovered']);
            $statistic_home->set_tackles($match_attr['home_team_statistics']['tackles']);
            $statistic_home->set_clearances($match_attr['home_team_statistics']['clearances']);
            $statistic_home->set_yellow_cards($match_attr['home_team_statistics']['yellow_cards']);
            $statistic_home->set_red_cards($match_attr['home_team_statistics']['red_cards']);
            $statistic_home->set_fouls_committed($match_attr['home_team_statistics']['fouls_committed']);
            $statistic_home->set_tactics($match_attr['home_team_statistics']['tactics']);
            $statistic_home->set_match_id($match->get_fifa_id());
            $statistic_home->set_home_team(1);

            $all_statistics[] = $statistic_home->create_query();

            $statistic_away = new Statistic();
            $statistic_away->set_team_code($match_team_away->get_code());
            $statistic_away->set_attempts_on_goal($match_attr['away_team_statistics']['attempts_on_goal']);
            $statistic_away->set_on_target($match_attr['away_team_statistics']['on_target']);
            $statistic_away->set_off_target($match_attr['away_team_statistics']['off_target']);
            $statistic_away->set_blocked($match_attr['away_team_statistics']['blocked']);
            $statistic_away->set_woodwork($match_attr['away_team_statistics']['woodwork']);
            $statistic_away->set_corners($match_attr['away_team_statistics']['corners']);
            $statistic_away->set_offsides($match_attr['away_team_statistics']['offsides']);
            $statistic_away->set_ball_possession($match_attr['away_team_statistics']['ball_possession']);
            $statistic_away->set_pass_accuracy($match_attr['away_team_statistics']['pass_accuracy']);
            $statistic_away->set_num_passes($match_attr['away_team_statistics']['num_passes']);
            $statistic_away->set_passes_completed($match_attr['away_team_statistics']['passes_completed']);
            $statistic_away->set_distance_covered($match_attr['away_team_statistics']['distance_covered']);
            $statistic_away->set_balls_recovered($match_attr['away_team_statistics']['balls_recovered']);
            $statistic_away->set_tackles($match_attr['away_team_statistics']['tackles']);
            $statistic_away->set_clearances($match_attr['away_team_statistics']['clearances']);
            $statistic_away->set_yellow_cards($match_attr['away_team_statistics']['yellow_cards']);
            $statistic_away->set_red_cards($match_attr['away_team_statistics']['red_cards']);
            $statistic_away->set_fouls_committed($match_attr['away_team_statistics']['fouls_committed']);
            $statistic_away->set_tactics($match_attr['away_team_statistics']['tactics']);
            $statistic_away->set_match_id($match->get_fifa_id());
            $statistic_away->set_home_team(0);

            $all_statistics[] = $statistic_away->create_query();
        }

        if ($match->match_event_update()) {
            $match->update_event_time();
            $event = new Event();
            $event->set_match_id($match->get_fifa_id());
            $event->delete_events();
            foreach ($match_attr['home_team_events'] as $values_event) {
                $event = new Event();
                $event->set_id($values_event['id']);
                $event->set_type_of_event($values_event['type_of_event']);
                $event->set_player($values_event['player']);
                $event->set_time($event->escape($values_event['time']));
                $event->set_match_id($match->get_fifa_id());
                $event->set_home_team(1);
                $event->set_team_code($mth);

                $all_events[] = $event->create_query();
            }

            foreach ($match_attr['away_team_events'] as $values_event) {
                $event = new Event();
                $event->set_id($values_event['id']);
                $event->set_match_id($match->get_fifa_id());
                $event->set_type_of_event($values_event['type_of_event']);
                $event->set_player($values_event['player']);
                $event->set_time($event->escape($values_event['time']));
                $event->set_match_id($match->get_fifa_id());
                $event->set_home_team(0);
                $event->set_team_code($mta);
                $all_events[] = $event->create_query();
            }

            $statistic_home = new Statistic();
            $statistic_home->set_match_id($match->get_fifa_id());
            $statistic_home->delete_statistics();
            
            $statistic_home->set_team_code($match_attr['home_team']['code']);
            $statistic_home->set_attempts_on_goal($match_attr['home_team_statistics']['attempts_on_goal']);
            $statistic_home->set_on_target($match_attr['home_team_statistics']['on_target']);
            $statistic_home->set_off_target($match_attr['home_team_statistics']['off_target']);
            $statistic_home->set_blocked($match_attr['home_team_statistics']['blocked']);
            $statistic_home->set_woodwork($match_attr['home_team_statistics']['woodwork']);
            $statistic_home->set_corners($match_attr['home_team_statistics']['corners']);
            $statistic_home->set_offsides($match_attr['home_team_statistics']['offsides']);
            $statistic_home->set_ball_possession($match_attr['home_team_statistics']['ball_possession']);
            $statistic_home->set_pass_accuracy($match_attr['home_team_statistics']['pass_accuracy']);
            $statistic_home->set_num_passes($match_attr['home_team_statistics']['num_passes']);
            $statistic_home->set_passes_completed($match_attr['home_team_statistics']['passes_completed']);
            $statistic_home->set_distance_covered($match_attr['home_team_statistics']['distance_covered']);
            $statistic_home->set_balls_recovered($match_attr['home_team_statistics']['balls_recovered']);
            $statistic_home->set_tackles($match_attr['home_team_statistics']['tackles']);
            $statistic_home->set_clearances($match_attr['home_team_statistics']['clearances']);
            $statistic_home->set_yellow_cards($match_attr['home_team_statistics']['yellow_cards']);
            $statistic_home->set_red_cards($match_attr['home_team_statistics']['red_cards']);
            $statistic_home->set_fouls_committed($match_attr['home_team_statistics']['fouls_committed']);
            $statistic_home->set_tactics($match_attr['home_team_statistics']['tactics']);
            $statistic_home->set_match_id($match->get_fifa_id());
            $statistic_home->set_home_team(1);

            $all_statistics[] = $statistic_home->create_query();

            $statistic_away = new Statistic();
            $statistic_away->set_team_code($match_attr['away_team']['code']);
            $statistic_away->set_attempts_on_goal($match_attr['away_team_statistics']['attempts_on_goal']);
            $statistic_away->set_on_target($match_attr['away_team_statistics']['on_target']);
            $statistic_away->set_off_target($match_attr['away_team_statistics']['off_target']);
            $statistic_away->set_blocked($match_attr['away_team_statistics']['blocked']);
            $statistic_away->set_woodwork($match_attr['away_team_statistics']['woodwork']);
            $statistic_away->set_corners($match_attr['away_team_statistics']['corners']);
            $statistic_away->set_offsides($match_attr['away_team_statistics']['offsides']);
            $statistic_away->set_ball_possession($match_attr['away_team_statistics']['ball_possession']);
            $statistic_away->set_pass_accuracy($match_attr['away_team_statistics']['pass_accuracy']);
            $statistic_away->set_num_passes($match_attr['away_team_statistics']['num_passes']);
            $statistic_away->set_passes_completed($match_attr['away_team_statistics']['passes_completed']);
            $statistic_away->set_distance_covered($match_attr['away_team_statistics']['distance_covered']);
            $statistic_away->set_balls_recovered($match_attr['away_team_statistics']['balls_recovered']);
            $statistic_away->set_tackles($match_attr['away_team_statistics']['tackles']);
            $statistic_away->set_clearances($match_attr['away_team_statistics']['clearances']);
            $statistic_away->set_yellow_cards($match_attr['away_team_statistics']['yellow_cards']);
            $statistic_away->set_red_cards($match_attr['away_team_statistics']['red_cards']);
            $statistic_away->set_fouls_committed($match_attr['away_team_statistics']['fouls_committed']);
            $statistic_away->set_tactics($match_attr['away_team_statistics']['tactics']);
            $statistic_away->set_match_id($match->get_fifa_id());
            $statistic_away->set_home_team(0);

            $all_statistics[] = $statistic_away->create_query();
        }
    } else {
        // if match doesen't exist in database import new data from file
        $match->set_venue($match_attr['venue']);
        $match->set_location($match_attr['location']);
        $match->set_status($match_attr['status']);
        $match->set_time($match_attr['time']);

        $match->set_attendance($match_attr['attendance']);
        $match->set_officials(json_encode($match_attr['officials']));
        $match->set_stage_name($match_attr['stage_name']);
        $match->set_datetime($match_attr['datetime']);
        $match->set_winner($match_attr['winner']);
        $match->set_winner_code($match_attr['winner_code']);

        $all_matches[] = $match->create_query();

        $match_team_home = new MatchTeam();
        $match_team_home->set_country($match_attr['home_team']['country']);
        $match_team_home->set_code($match_attr['home_team']['code']);
        $match_team_home->set_goals($match_attr['home_team']['goals']);
        $match_team_home->set_penalties($match_attr['home_team']['penalties']);
        $match_team_home->set_match_id($match->get_fifa_id());
        $match_team_home->set_home_team(1);

        $all_match_teams[] = $match_team_home->create_query();

        $match_team_away = new MatchTeam();
        $match_team_away->set_country($match_attr['away_team']['country']);
        $match_team_away->set_code($match_attr['away_team']['code']);
        $match_team_away->set_goals($match_attr['away_team']['goals']);
        $match_team_away->set_penalties($match_attr['away_team']['penalties']);
        $match_team_away->set_match_id($match->get_fifa_id());
        $match_team_away->set_home_team(0);

        $all_match_teams[] = $match_team_away->create_query();
        foreach ($match_attr['home_team_statistics']['starting_eleven'] as $key_player => $values_player) {
            $player = new Player();
            $player->set_name($values_player['name']);
            $player->set_captain($values_player['captain']);
            $player->set_shirt_number($values_player['shirt_number']);
            $player->set_position($values_player['position']);
            $player->set_match_id($match->get_fifa_id());
            $player->set_team_id($match_team_home->get_code());
            $player->set_starting_eleven(1);
            $all_players[] = $player->create_query();
        }
        foreach ($match_attr['home_team_statistics']['substitutes'] as $key_player => $values_player) {
            $player = new Player();
            $player->set_name($values_player['name']);
            $player->set_captain($values_player['captain']);
            $player->set_shirt_number($values_player['shirt_number']);
            $player->set_position($values_player['position']);
            $player->set_match_id($match->get_fifa_id());
            $player->set_team_id($match_team_home->get_code());
            $player->set_starting_eleven(0);
            $all_players[] = $player->create_query();
        }
        foreach ($match_attr['away_team_statistics']['starting_eleven'] as $key_player => $values_player) {
            $player = new Player();
            $player->set_name($values_player['name']);
            $player->set_captain($values_player['captain']);
            $player->set_shirt_number($values_player['shirt_number']);
            $player->set_position($values_player['position']);
            $player->set_match_id($match->get_fifa_id());
            $player->set_team_id($match_team_away->get_code());
            $player->set_starting_eleven(1);
            $all_players[] = $player->create_query();
        }
        foreach ($match_attr['away_team_statistics']['substitutes'] as $key_player => $values_player) {
            $player = new Player();
            $player->set_name($values_player['name']);
            $player->set_captain($values_player['captain']);
            $player->set_shirt_number($values_player['shirt_number']);
            $player->set_position($values_player['position']);
            $player->set_match_id($match->get_fifa_id());
            $player->set_team_id($match_team_away->get_code());
            $player->set_starting_eleven(0);

            $all_players[] = $player->create_query();
        }
        foreach ($match_attr['home_team_events'] as $values_event) {
            $event = new Event();
            $event->set_id($values_event['id']);
            $event->set_type_of_event($values_event['type_of_event']);
            $event->set_player($values_event['player']);
            $event->set_time($event->escape($values_event['time']));
            $event->set_match_id($match->get_fifa_id());
            $event->set_home_team(1);
            $event->set_team_code($match_team_home->get_code());

            $all_events[] = $event->create_query();
        }

        foreach ($match_attr['away_team_events'] as $values_event) {
            $event = new Event();
            $event->set_id($values_event['id']);
            $event->set_type_of_event($values_event['type_of_event']);
            $event->set_player($values_event['player']);
            $event->set_time($event->escape($values_event['time']));
            $event->set_match_id($match->get_fifa_id());
            $event->set_home_team(0);
            $event->set_team_code($match_team_home->get_code());

            $all_events[] = $event->create_query();
        }

        $weather = new Weather();
        $weather->set_match_id($match->get_fifa_id());
        $weather->set_humidity($match_attr['weather']['humidity']);
        $weather->set_temp_celsius($match_attr['weather']['temp_celsius']);
        $weather->set_temp_farenheit($match_attr['weather']['temp_farenheit']);
        $weather->set_wind_speed($match_attr['weather']['wind_speed']);
        $weather->set_description($match_attr['weather']['description']);

        $all_weather[] = $weather->create_query();


        $statistic_home = new Statistic();
        $statistic_home->set_team_code($match_team_home->get_code());
        $statistic_home->set_attempts_on_goal($match_attr['home_team_statistics']['attempts_on_goal']);
        $statistic_home->set_on_target($match_attr['home_team_statistics']['on_target']);
        $statistic_home->set_off_target($match_attr['home_team_statistics']['off_target']);
        $statistic_home->set_blocked($match_attr['home_team_statistics']['blocked']);
        $statistic_home->set_woodwork($match_attr['home_team_statistics']['woodwork']);
        $statistic_home->set_corners($match_attr['home_team_statistics']['corners']);
        $statistic_home->set_offsides($match_attr['home_team_statistics']['offsides']);
        $statistic_home->set_ball_possession($match_attr['home_team_statistics']['ball_possession']);
        $statistic_home->set_pass_accuracy($match_attr['home_team_statistics']['pass_accuracy']);
        $statistic_home->set_num_passes($match_attr['home_team_statistics']['num_passes']);
        $statistic_home->set_passes_completed($match_attr['home_team_statistics']['passes_completed']);
        $statistic_home->set_distance_covered($match_attr['home_team_statistics']['distance_covered']);
        $statistic_home->set_balls_recovered($match_attr['home_team_statistics']['balls_recovered']);
        $statistic_home->set_tackles($match_attr['home_team_statistics']['tackles']);
        $statistic_home->set_clearances($match_attr['home_team_statistics']['clearances']);
        $statistic_home->set_yellow_cards($match_attr['home_team_statistics']['yellow_cards']);
        $statistic_home->set_red_cards($match_attr['home_team_statistics']['red_cards']);
        $statistic_home->set_fouls_committed($match_attr['home_team_statistics']['fouls_committed']);
        $statistic_home->set_tactics($match_attr['home_team_statistics']['tactics']);
        $statistic_home->set_match_id($match->get_fifa_id());
        $statistic_home->set_home_team(1);

        $all_statistics[] = $statistic_home->create_query();

        $statistic_away = new Statistic();
        $statistic_away->set_team_code($match_team_away->get_code());
        $statistic_away->set_attempts_on_goal($match_attr['away_team_statistics']['attempts_on_goal']);
        $statistic_away->set_on_target($match_attr['away_team_statistics']['on_target']);
        $statistic_away->set_off_target($match_attr['away_team_statistics']['off_target']);
        $statistic_away->set_blocked($match_attr['away_team_statistics']['blocked']);
        $statistic_away->set_woodwork($match_attr['away_team_statistics']['woodwork']);
        $statistic_away->set_corners($match_attr['away_team_statistics']['corners']);
        $statistic_away->set_offsides($match_attr['away_team_statistics']['offsides']);
        $statistic_away->set_ball_possession($match_attr['away_team_statistics']['ball_possession']);
        $statistic_away->set_pass_accuracy($match_attr['away_team_statistics']['pass_accuracy']);
        $statistic_away->set_num_passes($match_attr['away_team_statistics']['num_passes']);
        $statistic_away->set_passes_completed($match_attr['away_team_statistics']['passes_completed']);
        $statistic_away->set_distance_covered($match_attr['away_team_statistics']['distance_covered']);
        $statistic_away->set_balls_recovered($match_attr['away_team_statistics']['balls_recovered']);
        $statistic_away->set_tackles($match_attr['away_team_statistics']['tackles']);
        $statistic_away->set_clearances($match_attr['away_team_statistics']['clearances']);
        $statistic_away->set_yellow_cards($match_attr['away_team_statistics']['yellow_cards']);
        $statistic_away->set_red_cards($match_attr['away_team_statistics']['red_cards']);
        $statistic_away->set_fouls_committed($match_attr['away_team_statistics']['fouls_committed']);
        $statistic_away->set_tactics($match_attr['away_team_statistics']['tactics']);
        $statistic_away->set_match_id($match->get_fifa_id());
        $statistic_away->set_home_team(0);

        $all_statistics[] = $statistic_away->create_query();
    }
}


// call import functions

$match = new Match();
if (count($all_matches) > 0) {
    if ($match->insert_matches($all_matches)) {
        echo "Matches import finished..<br>";
    } else {
        echo "Something's wrong with matches.. Matches not imported..<br>";
    }
} else {
    echo "Matches update finished<br>";
}

$match_team = new MatchTeam();

if (count($all_match_teams) > 0) {
    if ($match_team->insert_match_teams($all_match_teams)) {
        echo "Match Teams import finished..<br>";
    } else {
        echo "Something's wrong with match teams.. Match teams not imported..<br>";
    }
} else {
    echo "Match Teams update finished<br>";
}
$events = new Event();
if (count($all_events) > 0) {
    if ($events->insert_events($all_events)) {
        echo "Events import finished..<br>";
    } else {
        echo "Something's wrong with events.. Events not imported..<br>";
    }
} else {
    echo "Events update finished<br>";
}

$weather = new Weather();
if (count($all_weather) > 0) {
    if ($weather->insert_weather($all_weather)) {
        echo "Weather import finished..<br>";
    } else {
        echo "Something's wrong with weather.. Weather not imported..<br>";
    }
} else {
    echo "Weather update finished <br>";
}

$player = new Player();
if (count($all_players) > 0) {
    if ($player->insert_players($all_players)) {
        echo "Players import finished..<br>";
    } else {
        echo "Something's wrong with players.. Players not imported..<br>";
    }
} else {
    echo "Players update finished<br>";
}

$statistic = new Statistic();
if (count($all_statistics) > 0) {
    if ($statistic->insert_match_statistics($all_statistics)) {
        echo "Match Statistics import finished..<br>";
        // after match statistics update, also update teams table 
        $all_results = $statistic->get_results();
        $team = new Team();
        foreach ($all_results as $result_key => $result_value) {
            $team->set_fifa_code($result_value['code']);
            $team->update_teams_results($result_value['wins'], $result_value['losses'], $result_value['draws'], $result_value['games_played'], $result_value['points'], $result_value['goals_for'], $result_value['goals_against'], $result_value['goal_differential']);
        }

        echo "Teams table updated.. <br>";
    }
} else {
    echo "Statistics update finished <br>";
}

echo "<b>All finished!</b>";
