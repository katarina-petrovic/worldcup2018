<?php

/**
 * @author Kaca
 */
include_once 'Database.php';

class Team {

    /**
     * @var int
     */
    private $team_id;

    /**
     * @var string
     */
    private $fifa_code;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $alternate_name;

    /**
     * @var int
     */
    private $group_id;

    /**
     * @var string
     */
    private $group_letter;

    /**
     * @var object Database
     */
    private $db_connect;

    public function __construct() {
        $this->db_connect = new Database;
    }

    public function get_team_id() {
        return $this->team_id;
    }

    public function get_fifa_code() {
        return $this->fifa_code;
    }

    public function get_country() {
        return $this->country;
    }

    public function get_alternate_name() {
        return $this->alternate_name;
    }

    public function get_group_id() {
        return $this->group_id;
    }

    public function get_group_letter() {
        return $this->group_letter;
    }

    public function set_team_id($team_id) {
        $this->team_id = $team_id;
    }

    public function set_fifa_code($fifa_code) {
        $this->fifa_code = $fifa_code;
    }

    public function set_country($country) {
        $this->country = $country;
    }

    public function set_alternate_name($alternate_name) {
        $this->alternate_name = $alternate_name;
    }

    public function set_group_id($group_id) {
        $this->group_id = $group_id;
    }

    public function set_group_letter($group_letter) {
        $this->group_letter = $group_letter;
    }

    /*
     * escapes special characters in a string for use in sql query
     * 
     * @param   string $attribute 
     * @return  escaped string
     * @access  public
     */

    public function escape($attribute) {
        $output = mysqli_real_escape_string($this->db_connect->conn, $attribute);
        return $output;
    }

    /*
     * import team in table teams 
     * 
     * @return  boolean
     * @access  public
     */

    public function import_team() {
        $sql = "INSERT INTO teams (team_id, fifa_code, country, alternate_name, group_id, group_letter) VALUES ('$this->team_id', '$this->fifa_code', '$this->country', '$this->alternate_name', '$this->group_id', '$this->group_letter')";
        $sql .= " ON DUPLICATE KEY UPDATE fifa_code = '$this->fifa_code', country = '$this->country', alternate_name = '$this->alternate_name', group_id = '$this->group_id', group_letter = '$this->group_letter'";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * update statistics data for team in table teams 
     * 
     * @param  integer $wins 
     * @param  integer $losses 
     * @param  integer $draws 
     * @param  integer $games_played 
     * @param  integer $points 
     * @param  integer $goals_for 
     * @param  integer $goals_against 
     * @param  integer $goal_differential 
     * @return  boolean
     * @access  public
     */

    public function update_teams_results($wins, $losses, $draws, $games_played, $points, $goals_for, $goals_against, $goal_differential) {
        $sql = "UPDATE teams SET wins = '$wins', losses = '$losses' , draws = '$draws', games_played = '$games_played' ,points = '$points', goals_for = '$goals_for', goals_against = '$goals_against', goal_differential = '$goal_differential' WHERE fifa_code = '$this->fifa_code'";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * return all teams from table teams 
     * 
     * @return  string
     * @access  public
     */

    public function display_teams_json() {
        $sql = "SELECT * FROM teams";
        $all_results = array();
        $all_results_res = $this->db_connect->conn->query($sql);

        while ($row = mysqli_fetch_object($all_results_res)) {
            $row->team_id = (int) $row->team_id;
            $row->group_id = (int) $row->group_id;
            $row->wins = (int) $row->wins;
            $row->losses = (int) $row->losses;
            $row->draws = (int) $row->draws;
            $row->games_played = (int) $row->games_played;
            $row->points = (int) $row->points;
            $row->goals_for = (int) $row->goals_for;
            $row->goals_against = (int) $row->goals_against;
            $row->goal_differential = (int) $row->goal_differential;
            $all_results[] = $row;
        }

        return json_encode($all_results);
    }

    /*
     * delete all teams
     * 
     * 
     * @return  boolean
     * @access  public
     */

    public function delete() {
        $sql = "DELETE FROM teams";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

}
