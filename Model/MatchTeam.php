<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatchTeam
 *
 * @author Kaca
 */
class MatchTeam {

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $goals;

    /**
     * @var int
     */
    private $penalties;

    /**
     * @var int
     */
    private $home_team;

    /**
     * @var int
     */
    private $match_id;

    /**
     * @var object Database
     */
    private $db_connect;

    public function __construct() {
        $this->db_connect = new Database;
    }

    public function get_country() {
        return $this->country;
    }

    public function get_code() {
        return $this->code;
    }

    public function get_goals() {
        return $this->goals;
    }

    public function get_penalties() {
        return $this->penalties;
    }

    public function get_home_team() {
        return $this->home_team;
    }

    public function get_match_id() {
        return $this->match_id;
    }

    public function set_country($country) {
        $this->country = $country;
    }

    public function set_code($code) {
        $this->code = $code;
    }

    public function set_goals($goals) {
        $this->goals = $goals;
    }

    public function set_penalties($penalties) {
        $this->penalties = $penalties;
    }

    public function set_home_team($home_team) {
        $this->home_team = $home_team;
    }

    public function set_match_id($match_id) {
        $this->match_id = $match_id;
    }

    /*
     * update team result in match_teams table
     * 
     * @return  boolean
     * @access  public
     */

    public function update_match_team() {
        $sql = "UPDATE match_teams SET goals ='$this->goals', penalties = '$this->penalties' WHERE match_id = '$this->match_id' AND home_team='$this->home_team'";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return true;
        }
    }

    /*
     * create string of values for sql insert query 
     * 
     * @return  string
     * @access  public
     */

    public function create_query() {
        $insert_value = "('$this->match_id', '$this->country', '$this->code', '$this->goals', '$this->penalties', '$this->home_team')";
        return $insert_value;
    }

    /*
     * import team in table match_teams 
     * 
     * @param   array $all_match_teams 
     * @return  boolean
     * @access  public
     */

    public function insert_match_teams($all_match_teams) {
        if (count($all_match_teams) > 0) {
            $sql = "INSERT INTO match_teams (match_id, country, code, goals, penalties, home_team) VALUES " . implode(',', $all_match_teams);
            if ($this->db_connect->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * return all teams from table match_teams 
     * 
     * @param   integer $match_id
     * @return  array
     * @access  public
     */

    public function display_match_teams($match_id) {
        $sql = "SELECT country, code, goals, penalties, home_team FROM match_teams WHERE match_id = '$match_id'";
        $all_results = array();
        $match_team = array();
        $all_results_res = $this->db_connect->conn->query($sql);
        while ($row = mysqli_fetch_object($all_results_res)) {
            $match_team['country'] = $row->country;
            $match_team['code'] = $row->code;
            $match_team['goals'] = (int)$row->goals;
            $match_team['penalties'] = (int)$row->penalties;
            $all_results[$row->home_team] = $match_team;
        }
        return $all_results;
    }

}
