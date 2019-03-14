<?php

/**
 * Description of match
 *
 * @author Kaca
 */
include_once 'Database.php';

class Match {

    /**
     * @var int
     */
    private $fifa_id;

    /**
     * @var string
     */
    private $venue;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $time;

    /**
     * @var int
     */
    private $attendance;

    /**
     * @var string
     */
    private $officials;

    /**
     * @var string
     */
    private $stage_name;

    /**
     * @var datetime
     */
    private $datetime;

    /**
     * @var string
     */
    private $winner_code;

    /**
     * @var string
     */
    private $winner;

    /**
     * @var datetime
     */
    private $last_score_update_at;

    /**
     * @var datetime
     */
    private $last_event_update_at;

    /**
     * @var object Database
     */
    private $db_connect;

    public function __construct() {
        $this->db_connect = new Database;
    }

    public function get_fifa_id() {
        return $this->fifa_id;
    }

    public function get_venue() {
        return $this->venue;
    }

    public function get_location() {
        return $this->location;
    }

    public function get_status() {
        return $this->status;
    }

    public function get_time() {
        return $this->time;
    }

    public function get_attendance() {
        return $this->attendance;
    }

    public function get_officials() {
        return $this->officials;
    }

    public function get_stage_name() {
        return $this->stage_name;
    }

    public function get_datetime() {
        return $this->datetime;
    }

    public function get_winner_code() {
        return $this->winner_code;
    }

    public function get_winner() {
        return $this->winner;
    }

    public function set_winner($winner) {
        $this->winner = $winner;
    }

    public function get_last_score_update_at() {
        return $this->last_score_update_at;
    }

    public function get_last_event_update_at() {
        return $this->last_event_update_at;
    }

    public function set_fifa_id($fifa_id) {
        $this->fifa_id = $fifa_id;
    }

    public function set_venue($venue) {
        $this->venue = $venue;
    }

    public function set_location($location) {
        $this->location = $location;
    }

    public function set_status($status) {
        $this->status = $status;
    }

    public function set_time($time) {
        $this->time = $time;
    }

    public function set_attendance($attendance) {
        $this->attendance = $attendance;
    }

    public function set_officials($officials) {
        $this->officials = $officials;
    }

    public function set_stage_name($stage_name) {
        $this->stage_name = $stage_name;
    }

    public function set_datetime($datetime) {
        $this->datetime = $datetime;
    }

    public function set_winner_code($winner_code) {
        $this->winner_code = $winner_code;
    }

    public function set_last_score_update_at($last_score_update_at) {
        $this->last_score_update_at = $last_score_update_at;
    }

    public function set_last_event_update_at($last_event_update_at) {
        $this->last_event_update_at = $last_event_update_at;
    }

    /*
     * check if match exists in table matches
     * 
     * @return  boolean
     * @access  public
     */

    public function match_to_update() {
        $sql = "SELECT * FROM matches WHERE fifa_id='$this->fifa_id'";
        $all_results_res = $this->db_connect->conn->query($sql);
        if ($all_results_res->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * check if match score is updated comparing last_score_update_at from table and last_score_update_at from file
     * 
     * @return  boolean
     * @access  public
     */

    public function match_score_update() {
        if ($this->last_score_update_at != "") {
            $date_score_update = $this->fix_date($this->last_score_update_at);
            $sql = "SELECT * FROM matches WHERE fifa_id='$this->fifa_id' AND last_score_update_at < '$date_score_update'";
            $all_results_res = $this->db_connect->conn->query($sql);
            if ($all_results_res->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * check if match event is updated comparing last_event_update_at from table and last_event_update_at from file
     * 
     * @return  boolean
     * @access  public
     */

    public function match_event_update() {
        if ($this->last_event_update_at != "") {
            $date_event_update = $this->fix_date($this->last_event_update_at);
            $sql = "SELECT * FROM matches WHERE fifa_id='$this->fifa_id' AND last_event_update_at < '$date_event_update'";
            $all_results_res = $this->db_connect->conn->query($sql);
            if ($all_results_res->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * update score time in matches table
     * 
     * @return  boolean
     * @access  public
     */

    public function update_score_time() {
        $sql = "UPDATE matches SET last_score_update_at ='$this->last_score_update_at' WHERE fifa_id = '$this->fifa_id'";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * update event time in matches table
     * 
     * @return  boolean
     * @access  public
     */

    public function update_event_time() {
        $sql = "UPDATE matches SET last_event_update_at ='$this->last_event_update_at' WHERE fifa_id = '$this->fifa_id'";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * update event time in matches table
     * 
     * @param   datetime $date
     * @return  datetime
     * @access  public
     */

    public function fix_date($date) {
        $time = date("Y-m-d H:i:s", strtotime($date));
        return $time;
    }

    /*
     * create string of values for sql insert query 
     * 
     * @return  string
     * @access  public
     */

    public function create_query() {
        $insert_value = "('$this->fifa_id', '$this->venue', '$this->location', '$this->status', '$this->time', '$this->attendance', '$this->officials', '$this->stage_name', '$this->datetime', '$this->winner_code', '$this->winner', '$this->last_score_update_at', '$this->last_event_update_at')";
        return $insert_value;
    }

    /*
     * import team in table teams 
     * 
     * @return  boolean
     * @access  public
     */

    public function insert_matches($all_matches) {
        if (count($all_matches) > 0) {
            $sql = "INSERT INTO matches (fifa_id, venue, location, status, time, attendance, officials, stage_name, datetime, winner_code, winner, last_score_update_at, last_event_update_at) VALUES " . implode(',', $all_matches);
            if ($this->db_connect->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /*
     * return all matches from table matches sorted by temperature desc 
     * 
     * @return  array
     * @access  public
     */

    public function display_matches() {
        $sql = "SELECT matches.*, weather.humidity, weather.temp_celsius, weather.temp_farenheit, weather.wind_speed, weather.description FROM `matches` INNER JOIN weather ON matches.fifa_id = weather.match_id ORDER BY weather.temp_celsius DESC";
        $all_results = array();
        $all_results_res = $this->db_connect->conn->query($sql);
        while ($row = mysqli_fetch_object($all_results_res)) {
            if ($row->last_score_update_at == "0000-00-00 00:00:00") {
                $row->last_score_update_at = "";
            }
            if ($row->last_event_update_at == "0000-00-00 00:00:00") {
                $row->last_event_update_at = "";
            }
            $all_results[] = $row;
        }
        return $all_results;
    }

    /*
     * delete all matches
     * 
     * all data from other tables will be deleted also (except table teams)
     * 
     * @return  boolean
     * @access  public
     */

    public function delete() {
        $sql = "DELETE FROM matches";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

}
