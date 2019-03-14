<?php

/**
 * @author Kaca
 */
class Weather {

    /**
     * @var int
     */
    private $match_id;

    /**
     * @var int
     */
    private $humidity;

    /**
     * @var int
     */
    private $temp_celsius;

    /**
     * @var int
     */
    private $temp_farenheit;

    /**
     * @var int
     */
    private $wind_speed;

    /**
     * @var string
     */
    private $description;

    /**
     * @var object Database
     */
    private $db_connect;

    public function __construct() {
        $this->db_connect = new Database;
    }

    public function get_match_id() {
        return $this->match_id;
    }

    public function get_humidity() {
        return $this->humidity;
    }

    public function get_temp_celsius() {
        return $this->temp_celsius;
    }

    public function get_temp_farenheit() {
        return $this->temp_farenheit;
    }

    public function get_wind_speed() {
        return $this->wind_speed;
    }

    public function get_description() {
        return $this->description;
    }

    public function set_match_id($match_id) {
        $this->match_id = $match_id;
    }

    public function set_humidity($humidity) {
        $this->humidity = $humidity;
    }

    public function set_temp_celsius($temp_celsius) {
        $this->temp_celsius = $temp_celsius;
    }

    public function set_temp_farenheit($temp_farenheit) {
        $this->temp_farenheit = $temp_farenheit;
    }

    public function set_wind_speed($wind_speed) {
        $this->wind_speed = $wind_speed;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    /*
     * create string of values for sql insert query 
     * 
     * @return  string
     * @access  public
     */
    public function create_query() {
        $insert_value = "('$this->match_id', '$this->humidity', '$this->temp_celsius', '$this->temp_farenheit', '$this->wind_speed', '$this->description')";
        return $insert_value;
    }

    /*
     * import weather in table weather 
     * 
     * @param   array $all_weather 
     * @return  boolean
     * @access  public
     */
    public function insert_weather($all_weather) {
        if (count($all_weather) > 0) {
            $sql = "INSERT INTO weather (match_id, humidity, temp_celsius, temp_farenheit, wind_speed, description) VALUES " . implode(',', $all_weather);
            if ($this->db_connect->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        }
    }
    

}
