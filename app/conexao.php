<?php

class Conexao{

    private $host    ="localhost";
    private $db_name ="banco_pdo";
    private $user    ="root";
    private $pass    ="";

    public function conectar(){
        try{
            $conexao = new PDO(
               "mysql:host=".$this->host.
                ";dbname=".$this->db_name,
                $this->user,
                $this->pass
            );
           
            return $conexao;
        
        } catch(PDOException $erro){
            echo '<p>'.$erro->getMessage().'</p>';
        }
    }

    public function __get($attr){
        return $attr;
    }

    public function __set($attr,$val){
        $this->$attr=$val;
    }


}
?>