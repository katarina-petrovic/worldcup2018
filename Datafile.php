<?php
/**
 * Datafile is class that contains function for reading json file 
 *
 * @author Kaca
 */
class Datafile {
    
    /*
     * reading json file
     * 
     * @param   string $filename is url of json file
     * @return  array of elements from json file
     * @access  public
     */
    public function read_file($filename) {
        $json = file_get_contents($filename);
        $json_arr = json_decode($json, true);        
        return $json_arr;
    }

}
