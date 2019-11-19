<?php 
// Executa CRUD da Tarefa(Create,Read,Update and Delete)
class TarefaService{

    private $conexao;
    public $tarefa;

    public function __construct(Conexao $conexao,Tarefa $tarefa){
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;


    }
    public function criar(){
        $query = 'INSERT INTO tb_tarefas(tarefa) VALUES (:tarefa)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa',$this->tarefa->__get('tarefa'));
        $stmt->execute();
    }
    public function ler(){
        $query = 'SELECT t.id,s.status,t.tarefa FROM tb_tarefas as t LEFT JOIN tb_status as s on (t.id_status = s.id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function atualizar(){
        $query = 'UPDATE tb_tarefas as t SET t.tarefa = (:tarefa) WHERE t.id = (:id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa',$this->tarefa->__get('tarefa'));
        $stmt->bindValue(':id',$this->tarefa->__get('id')); 
        $stmt->execute();      

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function remover(){
        $query = 'DELETE FROM tb_tarefas WHERE id=(:id)';                  
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id',$this->tarefa->__get('id'));        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function concluir(){
        $query = 'UPDATE tb_tarefas AS t SET t.id_status = (:id_status) WHERE t.id = (:id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id_status',$this->tarefa->__get('id_status'));        
        $stmt->bindValue(':id',$this->tarefa->__get('id'));
        $stmt->execute();
        //echo $this->tarefa->__get('id_status');
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function lerPendentes(){
        $query = 'SELECT t.id,t.tarefa FROM tb_tarefas as t WHERE t.id_status = (:id_status)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id_status',$this->tarefa->__get('id_status'));
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);        
    }
}

?>