<?php

/**
 * Description of Statistic
 *
 * @author Kaca
 */
include_once 'Database.php';

class Statistic {

    /**
     * @var string
     */
    private $team_code;

    /**
     * @var int
     */
    private $match_id;

    /**
     * @var int
     */
    private $home_team;

    /**
     * @var int
     */
    private $attempts_on_goal;

    /**
     * @var int
     */
    private $on_target;

    /**
     * @var int
     */
    private $off_target;

    /**
     * @var int
     */
    private $blocked;

    /**
     * @var int
     */
    private $woodwork;

    /**
     * @var int
     */
    private $corners;

    /**
     * @var int
     */
    private $offsides;

    /**
     * @var int
     */
    private $ball_possession;

    /**
     * @var int
     */
    private $pass_accuracy;

    /**
     * @var int
     */
    private $num_passes;

    /**
     * @var int
     */
    private $passes_completed;

    /**
     * @var int
     */
    private $distance_covered;

    /**
     * @var int
     */
    private $balls_recovered;

    /**
     * @var int
     */
    private $tackles;

    /**
     * @var int
     */
    private $clearances;

    /**
     * @var int
     */
    private $yellow_cards;

    /**
     * @var int
     */
    private $red_cards;

    /**
     * @var int
     */
    private $fouls_committed;

    /**
     * @var int
     */
    private $tactics;

    /**
     * @var object Database
     */
    private $db_connect;

    public function __construct() {
        $this->db_connect = new Database;
    }

    public function get_team_code() {
        return $this->team_code;
    }

    public function get_match_id() {
        return $this->match_id;
    }

    public function get_home_team() {
        return $this->home_team;
    }

    public function get_attempts_on_goal() {
        return $this->attempts_on_goal;
    }

    public function get_on_target() {
        return $this->on_target;
    }

    public function get_off_target() {
        return $this->off_target;
    }

    public function get_blocked() {
        return $this->blocked;
    }

    public function get_woodwork() {
        return $this->woodwork;
    }

    public function get_corners() {
        return $this->corners;
    }

    public function get_offsides() {
        return $this->offsides;
    }

    public function get_ball_possession() {
        return $this->ball_possession;
    }

    public function get_pass_accuracy() {
        return $this->pass_accuracy;
    }

    public function get_num_passes() {
        return $this->num_passes;
    }

    public function get_passes_completed() {
        return $this->passes_completed;
    }

    public function get_distance_covered() {
        return $this->distance_covered;
    }

    public function get_balls_recovered() {
        return $this->balls_recovered;
    }

    public function get_tackles() {
        return $this->tackles;
    }

    public function get_clearances() {
        return $this->clearances;
    }

    public function get_yellow_cards() {
        return $this->yellow_cards;
    }

    public function get_red_cards() {
        return $this->red_cards;
    }

    public function get_fouls_committed() {
        return $this->fouls_committed;
    }

    public function get_tactics() {
        return $this->tactics;
    }

    public function set_team_code($team_code) {
        $this->team_code = $team_code;
    }

    public function set_match_id($match_id) {
        $this->match_id = $match_id;
    }

    public function set_home_team($home_team) {
        $this->home_team = $home_team;
    }

    public function set_attempts_on_goal($attempts_on_goal) {
        $this->attempts_on_goal = $attempts_on_goal;
    }

    public function set_on_target($on_target) {
        $this->on_target = $on_target;
    }

    public function set_off_target($off_target) {
        $this->off_target = $off_target;
    }

    public function set_blocked($blocked) {
        $this->blocked = $blocked;
    }

    public function set_woodwork($woodwork) {
        $this->woodwork = $woodwork;
    }

    public function set_corners($corners) {
        $this->corners = $corners;
    }

    public function set_offsides($offsides) {
        $this->offsides = $offsides;
    }

    public function set_ball_possession($ball_possession) {
        $this->ball_possession = $ball_possession;
    }

    public function set_pass_accuracy($pass_accuracy) {
        $this->pass_accuracy = $pass_accuracy;
    }

    public function set_num_passes($num_passes) {
        $this->num_passes = $num_passes;
    }

    public function set_passes_completed($passes_completed) {
        $this->passes_completed = $passes_completed;
    }

    public function set_distance_covered($distance_covered) {
        $this->distance_covered = $distance_covered;
    }

    public function set_balls_recovered($balls_recovered) {
        $this->balls_recovered = $balls_recovered;
    }

    public function set_tackles($tackles) {
        $this->tackles = $tackles;
    }

    public function set_clearances($clearances) {
        $this->clearances = $clearances;
    }

    public function set_yellow_cards($yellow_cards) {
        $this->yellow_cards = $yellow_cards;
    }

    public function set_red_cards($red_cards) {
        $this->red_cards = $red_cards;
    }

    public function set_fouls_committed($fouls_committed) {
        $this->fouls_committed = $fouls_committed;
    }

    public function set_tactics($tactics) {
        $this->tactics = $tactics;
    }

    /*
     * create string of values for sql insert query 
     * 
     * @return  string
     * @access  public
     */

    public function create_query() {
        $insert_value = "('$this->team_code', '$this->match_id', '$this->home_team', '$this->attempts_on_goal', '$this->on_target', '$this->off_target', '$this->blocked', '$this->woodwork', '$this->corners', '$this->offsides', '$this->ball_possession', '$this->pass_accuracy', '$this->num_passes', '$this->passes_completed', '$this->distance_covered', '$this->balls_recovered', '$this->tackles', '$this->clearances', '$this->yellow_cards', '$this->red_cards', '$this->fouls_committed', '$this->tactics')";
        return $insert_value;
    }

    /*
     * import match statistic data in table match_statistics 
     * 
     * @param   array $all_statistics 
     * @return  boolean
     * @access  public
     */

    
    public function insert_match_statistics($all_statistics) {
        if (count($all_statistics) > 0) {
            $sql = "INSERT INTO match_statistics (team_code, match_id, home_team, attempts_on_goal, on_target, off_target, blocked, woodwork, corners, offsides, ball_possession, pass_accuracy, num_passes, passes_completed, distance_covered, balls_recovered, tackles, clearances, yellow_cards, red_cards, fouls_committed, tactics) VALUES " . implode(',', $all_statistics);
            if ($this->db_connect->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * delete statistics for selected match_id
     * 
     * @return  boolean
     * @access  public
     */

    public function delete_statistics() {
        $sql = "DELETE FROM match_statistics WHERE match_id = '$this->match_id'";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            echo mysqli_error($this->db_connect->conn);
        }
    }
    /*
     * get summary statistics for each team  
     * use after matches import to update data in teams table
     * 
     * @param   array $all_statistics 
     * @return  array
     * @access  public
     */

    public function get_results() {
        $sql = "SELECT code, "
                . "SUM(goals_for) as goals_for, SUM(goals_against) as goals_against, SUM(wins) as wins, SUM(draws) as draws, SUM(losses) as losses, SUM(goal_differential) as goal_differential, COUNT(code) as games_played, (SUM(wins)*3 + SUM(draws)) as points "
                . "FROM (SELECT mt1.code, mt1.goals as goals_for, mt2.goals as goals_against, IF( mt1.goals > mt2.goals, 1, 0) as wins, "
                . "IF( mt1.goals = mt2.goals, 1, 0) as draws, IF( mt1.goals < mt2.goals, 1, 0) as losses, (mt1.goals - mt2.goals) as goal_differential "
                . "FROM `match_teams` as mt1 INNER JOIN match_teams as mt2 ON mt1.match_id=mt2.match_id WHERE mt1.home_team != mt2.home_team) as results GROUP BY code";
        $all_results = array();
        $all_results_res = $this->db_connect->conn->query($sql);

        while ($row = mysqli_fetch_array($all_results_res)) {
            $all_results[] = $row;
        }

        return $all_results;
    }

    /*
     * return all match statistics from table statistics 
     * 
     * @param   integer $match_id
     * @return  array
     * @access  public
     */

    public function display_match_statistics($match_id) {
        $sql = "SELECT * FROM match_statistics WHERE match_id = '$match_id'";
        $all_results = array();
        $match_team = array();
        $all_results_res = $this->db_connect->conn->query($sql);
        while ($row = mysqli_fetch_object($all_results_res)) {
            $match_team['country'] = $row->team_code;
            $match_team['attempts_on_goal'] = (int)$row->attempts_on_goal;
            $match_team['on_target'] = (int)$row->on_target;
            $match_team['off_target'] = (int)$row->off_target;
            $match_team['blocked'] = (int)$row->blocked;
            $match_team['woodwork'] = (int)$row->woodwork;
            $match_team['corners'] = (int)$row->corners;
            $match_team['offsides'] = (int)$row->offsides;
            $match_team['ball_possession'] = (int)$row->ball_possession;
            $match_team['pass_accuracy'] = (int)$row->pass_accuracy;
            $match_team['num_passes'] = (int)$row->num_passes;
            $match_team['passes_completed'] = (int)$row->passes_completed;
            $match_team['distance_covered'] = (int)$row->distance_covered;
            $match_team['balls_recovered'] = (int)$row->balls_recovered;
            $match_team['tackles'] = (int)$row->tackles;
            $match_team['clearances'] = (int)$row->clearances;
            $match_team['yellow_cards'] = (int)$row->yellow_cards;
            $match_team['red_cards'] = (int)$row->red_cards;
            $match_team['fouls_committed'] = (int)$row->fouls_committed;
            $match_team['tactics'] = $row->tactics;
            $all_results[$row->home_team] = $match_team;
        }
        return $all_results;
    }

}
