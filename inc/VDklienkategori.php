<?php
/* 
 * This is the Class for VDklienkategori.
 */
 
Class VDklienkategori {
    
    public $wpdb;
    public $tablename;
    
    function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb; 
        $this->tablename = $wpdb->prefix.'vdklien_kategori';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $this->create_table();
    }
    
    public function create_table(){
        $sql = "CREATE TABLE IF NOT EXISTS $this->tablename
        (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            type varchar(255) NOT NULL,
            count varchar(255) NOT NULL,
            PRIMARY KEY  (id)
        );  
        ";
        dbDelta($sql);
    }
    
    /// add new notif to User ID
    public function add($name=null,$type=null){
        if($name && $type ) {
            $this->wpdb->insert($this->tablename, array(
                'name'   => $name,
                'type'   => $type,
                'count'  => 0,
              )
        	);
        }
    }
    
    /// update by ID
    public function update($id=null,$name=null) {
        if($name && $id ) {
            $this->wpdb->update($this->tablename, array(
                'name'        => $name,
                ),array(
                    'id'      => $id,
                )
            );
        }
    }

    /// update by ID
    public function updatecount($id=null,$count=null) {
        if($count && $id ) {
            $this->wpdb->update($this->tablename, array(
                'count'        => $count,
                ),array(
                    'id'      => $id,
                )
            );
        }
    }
    
    /// deleted notif by ID
    public function delete($id=null) {
        if($id) {
            $this->wpdb->delete($this->tablename, array(
                'id'          => $id,
            )
            );
        }
    } 

    /// deleted notif by ID
    public function get($arg=null) {
        $getdata = $this->wpdb->get_results("SELECT * FROM $this->tablename $arg ",ARRAY_A);
        return $getdata;
    }       
    
}

//run function for create table
$VDklienkategori = new VDklienkategori();