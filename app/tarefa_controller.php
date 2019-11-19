<?php

    require '../app/conexao.php';
    require '../app/tarefa.model.php';
    require '../app/tarefa.service.php';
       
    $acao = isset($_GET['acao'])? $_GET['acao'] : $acao;
    if($acao){        
        switch ($acao){
            case 'inserir':
                $tarefa = new Tarefa();
                $tarefa->__set('tarefa',$_POST['tarefa']);        
                $conexao = new Conexao();        
                $tarefaService = new TarefaService($conexao,$tarefa);   
                $tarefaService->criar();    
                header('Location:nova_tarefa.php?status=1');
                break; 

            case 'recuperar':
                $tarefa = new Tarefa();
                $conexao = new Conexao();
                $tarefaService = new TarefaService($conexao,$tarefa);
                $tarefas = $tarefaService->ler();
                break;
            
            case 'recuperarPendentes':
                $tarefa = new Tarefa();
                $tarefa->__set('id_status',1);
                $conexao = new Conexao();
                $tarefaService = new TarefaService($conexao,$tarefa);
                $tarefasPendentes = $tarefaService->lerPendentes();                
                break;
            
            case 'editar':
                //echo "editando no banco...";
                $tarefa = new Tarefa();
                $tarefa->__set('tarefa',$_POST['tarefa']);
                $tarefa->__set('id',$_POST['id']);
                $conexao = new Conexao();
                $tarefaService = new TarefaService($conexao,$tarefa);                
                if($tarefaService->atualizar() > 0){
                    if(isset($_GET['page']) && ($_GET['page'] =='index')){
                        header('Location:index.php?done=editar&status=1');
                    }else{
                        header('Location:todas_tarefas.php?done=editar&status=1');  
                    }                    
                }else{
                    header('Location:todas_tarefas.php?status=2');
                }                         
                break;

            case 'remover':            
                $tarefa = new Tarefa();
                $tarefa->__set('id',$_POST['id']);  
                $conexao= new Conexao();
                $tarefaService = new TarefaService($conexao,$tarefa);                
                if(($tarefaService->remover()) > 0){
                    header('Location:todas_tarefas.php?done=remover&status=1');                    
                }             
                break;
            case 'concluir':
                $tarefa = new Tarefa();
                $tarefa->__set('id',$_POST['id']);
                $tarefa->__set('id_status',2);  
                $conexao= new Conexao();
                $tarefaService = new TarefaService($conexao,$tarefa);                
                if(($tarefaService->concluir()) > 0){
                    header('Location:todas_tarefas.php?done=concluir&status=1');                    
                }
                break;
            default:
                echo "Ação não foi definida";
                break;
            
                       
        }
    }
?>