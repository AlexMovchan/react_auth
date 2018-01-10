<?php

class DataBase
{
    public $host;
    public $user;
    public $pass;
    public $database;
    public $link;
    public $is_Affected;
    public $is_Error;


    public function DataBase()
    {
        $this->host="localhost:3306";
        $this->user="root";
        $this->pass="mysql";
        $this->database="comment";
        $this->isLogged=true;
        $this->logLevel="Errors";//all/errors        
        $this->info = array();
        $this->is_Affected = false;
        $this->is_Error = false;
        $this->errormsg = "";
        $this->Connect();
        
    }

    public function Collect()
    {      
        if(isset($this->link->info))
        {
        if($this->link->info!= null && $this->link->info!="")
        {
            $this->info=explode('  ',$this->link->info);
            foreach ($this->info as $info) {
                $a2=explode(': ',$info);
                $this->info[$a2[0]]=$a2[1];
            }
        } 
        }
        if($this->link!=null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }


    public function Connect()
    {
        $this->link = mysqli_connect($this->host, $this->user, $this->pass);
        if($this->link === false) {
            return mysqli_connect_error();
        }
        mysqli_select_db($this->link,$this->database);
    }

 
    public function Select($sql)
    {
        $this->is_Error = false;
        $this->errormsg = "";
        if(!isset($this->link))
        {
            $this->Connect();
        }
        $result = mysqli_query($this->link,$sql);
        $error = mysqli_error($this->link) != '' ? true : false;

        if($this->isLogged && $this->logLevel=="All")
        {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/mysql.log", "SQL Select:".$sql."\n", FILE_APPEND | LOCK_EX);
        }

        if(!$error)
        {
            $dar = array();

            while ($data = $result->fetch_assoc())
            {
                $dar[] = $data;
            }
        }
        else 
        {            
            $log = mysqli_error($this->link)."\n";
            if($this->isLogged)
            {
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/mysql.log", "SQL Select:".$sql."\n", FILE_APPEND | LOCK_EX);
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/mysql.log", $log, FILE_APPEND | LOCK_EX);   
            }
            return null;     
            $this->is_Error = true;  
            $this->errormsg = $log;     
        }
        $this->Collect();
        return $dar;       
    }
    
    public function Insert($sql)
    {
        $this->is_Affected = false;
        if(!isset($this->link))
        {
            $this->Connect();
        }
	    mysqli_query($this->link,$sql);
        if($this->isLogged && $this->logLevel=="All")
        {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/mysql.log", "SQL Request Insert:".$sql."\n", FILE_APPEND | LOCK_EX);
        }
        $error = mysqli_error($this->link) != '' ? true : false;
        if($error)
        {
            $log = mysqli_error($this->link)."\n";
            $log_c = mysqli_error($this->link);
            if($this->isLogged)
            {
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/mysql.log", "SQL Request Insert:".$sql."\n", FILE_APPEND | LOCK_EX);
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/mysql.log", $log, FILE_APPEND | LOCK_EX);
            }
        }
        if(!$error)
        {
            $this->is_Affected = true;
        }
        $this->Collect();
        return $this->is_Affected;
    }
}
?>