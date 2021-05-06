<?php
/* 
 * This is the Class for VDklienklien.
 */
 
Class VDklienklien {
    
    public $wpdb;
    public $tablename;
    
    function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb; 
        $this->tablename = $wpdb->prefix.'vdklien_klien';
        $this->tablekategori = $wpdb->prefix.'vdklien_kategori';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $this->create_table();
    }
    
    public function create_table(){
        $sql = "CREATE TABLE IF NOT EXISTS $this->tablename
        (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            nama varchar(255) NOT NULL,
            kategori varchar(255) NOT NULL,
            paket varchar(255) NOT NULL,
            PRIMARY KEY  (id)
        );  
        ";
        dbDelta($sql);
    }
    
    /// add new notif to User ID
    public function add($nama=null,$kategori=null,$paket=null){
        if($nama) {
            $this->wpdb->insert($this->tablename, array(
                'nama'          => $nama,
                'kategori'      => $kategori,
                'paket'         => $paket,
              )
        	);
        }
        if(!empty($kategori)):
            $this->countkategori($kategori);
        endif;
        if(!empty($paket)):
            $this->countpaket($paket);
        endif;
    }
    
    /// update by ID
    /* 
    * arguments array $arg
    * array(
        'nama'      => $nama,
        'kategori'  => $kategori,
        'paket'     => $paket,
    );
    */
    public function update($id=null,$arg) {
        if($id && $arg) {
            $this->wpdb->update(
                $this->tablename,$arg,array('id'=> $id,)
            );
        }
        if(isset($arg['kategori'])):
            $this->countkategori($arg['kategori']);
        endif;
        if(isset($arg['paket'])):
            $this->countpaket($arg['paket']);
        endif;
    }
    
    /// deleted by ID
    public function delete($id=null) {
        if($id) {
            $this->wpdb->delete($this->tablename, array(
                'id' => $id,
            )
            );
        }
        if(isset($arg['kategori'])):
            $this->countkategori($arg['kategori']);
        endif;
        if(isset($arg['paket'])):
            $this->countpaket($arg['paket']);
        endif;
    } 

    /// fetch data
    public function get($arg=null) {
        $getdata = $this->wpdb->get_results("SELECT * FROM $this->tablename $arg ",ARRAY_A);
        return $getdata;
    }  

    /// fetch count data
    public function count($arg=null) {
        $getdata = $this->wpdb->get_var("SELECT COUNT(*) FROM $this->tablename $arg ");
        return $getdata;
    }  
    
    /// hitung dan update kategori
    public function countkategori($cat){
        if($cat):
            $getcount = $this->wpdb->get_var("SELECT COUNT(*) FROM $this->tablename WHERE kategori = $cat");
            if($getcount):
                $this->wpdb->update($this->tablekategori, array(
                    'count' => $getcount,
                    ),array(
                    'id' => $cat,
                    )
                );
            endif;
        endif;            
    }

    /// hitung dan update kategori
    public function countpaket($paket){
        if($paket):
            $getcount = $this->wpdb->get_var("SELECT COUNT(*) FROM $this->tablename WHERE paket = $paket");
            if($getcount):
                $this->wpdb->update($this->tablekategori, array(
                    'count' => $getcount,
                    ),array(
                    'id' => $paket,
                    )
                );
            endif;
        endif;            
    }
    
}

//run function for create table
$VDklienklien = new VDklienklien();