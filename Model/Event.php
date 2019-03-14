<?php

/**
 * @author Kaca
 */
class Event {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type_of_event;

    /**
     * @var string
     */
    private $player;

    /**
     * @var string
     */
    private $time;

    /**
     * @var string
     */
    private $home_team;

    /**
     * @var int
     */
    private $match_id;

    /**
     * @var string
     */
    private $team_code;

    /**
     * @var object Database
     */
    private $db_connect;

    public function __construct() {
        $this->db_connect = new Database;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_type_of_event() {
        return $this->type_of_event;
    }

    public function get_player() {
        return $this->player;
    }

    public function get_time() {
        return $this->time;
    }

    public function get_home_team() {
        return $this->home_team;
    }

    public function get_match_id() {
        return $this->match_id;
    }

    public function get_team_code() {
        return $this->team_code;
    }

    public function set_type_of_event($type_of_event) {
        $this->type_of_event = $type_of_event;
    }

    public function set_player($player) {
        $this->player = $player;
    }

    public function set_time($time) {
        $this->time = $time;
    }

    public function set_home_team($home_team) {
        $this->home_team = $home_team;
    }

    public function set_match_id($match_id) {
        $this->match_id = $match_id;
    }

    public function set_team_code($team_code) {
        $this->team_code = $team_code;
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
     * delete all events with selected match_id
     * 
     * @return  boolean
     * @access  public
     */

    public function delete_events() {
        $sql = "DELETE FROM events WHERE match_id = '$this->match_id'";
        if ($this->db_connect->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * create string of values for sql insert query 
     * 
     * @return  string
     * @access  public
     */

    public function create_query() {
        $insert_value = "('$this->id','$this->type_of_event', '$this->player', '$this->time', '$this->home_team', '$this->match_id', '$this->team_code')";
        return $insert_value;
    }

    /*
     * import events in table events 
     * 
     * @param   array $all_events 
     * @return  boolean
     * @access  public
     */

    public function insert_events($all_events) {
        if (count($all_events) > 0) {
            $sql = "INSERT INTO events (id, type_of_event, player, time, home_team, match_id, team_code) VALUES " . implode(',', $all_events);
            if ($this->db_connect->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * return all events from table events 
     * 
     * @param   integer $match_id
     * @param   integer $host 1 for home_team, 0 for away_team
     * @return  array
     * @access  public
     */

    public function display_events($match_id) {
        $sql = "SELECT id, type_of_event, player, time, home_team FROM events WHERE match_id = '$match_id'";
        $all_results = array();
        $match_event = array();
        $all_results_res = $this->db_connect->conn->query($sql);
        while ($row = mysqli_fetch_object($all_results_res)) {
            $match_event['id'] = (int)$row->id;
            $match_event['type_of_event'] = $row->type_of_event;
            $match_event['player'] = $row->player;
            $match_event['time'] = $row->time;
            $all_results[$row->home_team][] = $match_event;
        }
        return $all_results;
    }

}
