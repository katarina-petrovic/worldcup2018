<?php

/**
 * @author Kaca
 */
class Player {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $position;

    /**
     * @var int
     */
    private $shirt_number;

    /**
     * @var string
     */
    private $team_id;

    /**
     * @var int
     */
    private $match_id;

    /**
     * @var int
     */
    private $captain;

    /**
     * @var int
     */
    private $starting_eleven;

    /**
     * @var object Database
     */
    private $db_connect;

    public function __construct() {
        $this->db_connect = new Database;
    }

    function get_name() {
        return $this->name;
    }

    function get_position() {
        return $this->position;
    }

    function get_shirt_number() {
        return $this->shirt_number;
    }

    function get_team_id() {
        return $this->team_id;
    }

    function get_match_id() {
        return $this->match_id;
    }

    function get_captain() {
        return $this->captain;
    }

    function get_starting_eleven() {
        return $this->starting_eleven;
    }

    function set_name($name) {
        $this->name = $name;
    }

    function set_position($position) {
        $this->position = $position;
    }

    function set_shirt_number($shirt_number) {
        $this->shirt_number = $shirt_number;
    }

    function set_team_id($team_id) {
        $this->team_id = $team_id;
    }

    function set_match_id($match_id) {
        $this->match_id = $match_id;
    }

    function set_captain($captain) {
        $this->captain = $captain;
    }

    function set_starting_eleven($starting_eleven) {
        $this->starting_eleven = $starting_eleven;
    }

    /*
     * create string of values for sql insert query 
     * 
     * @return  string
     * @access  public
     */

    public function create_query() {
        $insert_value = "('$this->name', '$this->position', '$this->shirt_number', '$this->team_id', '$this->match_id', '$this->captain', '$this->starting_eleven')";
        return $insert_value;
    }

    /*
     * import players in table players 
     * 
     * @param   array $all_players 
     * @return  boolean
     * @access  public
     */

    public function insert_players($all_players) {
        if (count($all_players) > 0) {
            $sql = "INSERT INTO players (name, position, shirt_number, team_id, match_id, captain, starting_eleven) VALUES " . implode(',', $all_players);
            if ($this->db_connect->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * return all players from table players 
     * 
     * @param   integer $match_id
     * @return  array
     * @access  public
     */

    public function display_players($match_id) {
        $sql = "SELECT name, captain, shirt_number, position, starting_eleven, team_id  FROM players WHERE match_id = '$match_id'";
        $all_results = array();
        $match_team = array();
        $all_results_res = $this->db_connect->conn->query($sql);
        while ($row = mysqli_fetch_object($all_results_res)) {
            $match_team['name'] = $row->name;
            $captain = "";
            if($row->captain == 1){
                $captain = 1;
            }
            $match_team['captain'] = $captain;
            $match_team['shirt_number'] = (int)$row->shirt_number;
            $match_team['position'] = $row->position;
            $all_results[$row->team_id][$row->starting_eleven][] = $match_team;
        }
        return $all_results;
    }

}
