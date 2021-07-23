<?php    
    // CRUD TABELA DE HIGHSCORE
        
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Content-type: application/json; charset=UTF-8');
    
    require_once 'Class.Crud.php';
    require_once 'Class.Conexao.php';
    
    # Estabelece Conexão com o BANCO DE DADOS
    
    // Class.Conexao.php
    $pdo = Conexao::getConexao();
    
    // Class.Class.Crud.php
    // CrudClass::setConexao($pdo);
    CrudClass::setConexao($pdo);

    $uri = basename($_SERVER['REQUEST_URI']);

#############################################################################################
        
    // ### GET (Consulta)
    if ($_SERVER['REQUEST_METHOD'] == 'GET'):
        
        // echo json_encode( ['verbo_http' => $_SERVER['REQUEST_METHOD']] );
    
        if ( !Empty($uri) && $uri <> 'index.php' ):    
            // "WORLD RECORDS"
            if ($uri == 'allData'):                
                $dados = CrudClass::select('SELECT * FROM highscore ORDER BY score DESC LIMIT 10',[],TRUE);
            
            
            // "HIGHEST SCORE + PERSONAL BEST"
            else:
                if (!is_numeric($uri)):
                    $dados = CrudClass::select("
                        (SELECT id, score, playername, data FROM highscore ORDER BY score DESC LIMIT 1)
                        UNION
                        (SELECT id, score, playername, data FROM highscore WHERE playername = :PLAYER_NAME ORDER BY score DESC LIMIT 1)"
                        ,['PLAYER_NAME' => $uri]
                        ,TRUE);                
                else:
                    echo json_encode(['mensagem' => 'Parâmetro inválido!']);
                endif;
            endif;
            
            if (!Empty($dados)):  
                echo json_encode($dados);
                http_response_code(200);
            else:
                echo json_encode(['mensagem' => 'Pesquisa nao encontrada!']);
                // http_response_code(406);
                exit;
            endif;
        else:
            http_response_code(406);
            echo json_encode(['mensagem' => 'Parâmetro não preenchido na consulta!']);
            exit;
        endif;
    endif;
    
    
    // ### POST (INCLUSÃO)
    // No INSOMINIA, utilizar o "MULTIPART FORM" (Structured)    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'):
        
        // echo json_encode( ['verbo_http' => $_SERVER['REQUEST_METHOD']] );
    
        $id         = (isset($_POST['id'])) ? $_POST['id'] : ''                             ;
        $playerName = (isset($_POST['playername'])) ? $_POST['playername'] : ''             ;
        $score      = (isset($_POST['score'])) ? $_POST['score'] : ''                       ;
        $date       = 'CURDATE()'                                                           ;

        if (empty($playerName) or empty($score)):
            echo json_encode(['mensagem' => 'Informe Todos os Parâmetros!']);
            http_response_code(406);
            exit;
        endif;

        # TEMPORARIAMENTE FAÇO UM SELECT PARA VERIFICAR SCORE JÁ EXISTENTE DE PLAYER
        $dados = CrudClass::select(
            'SELECT score FROM highscore WHERE playername = :PLAYER_NAME ORDER BY score DESC LIMIT 1',
            ['PLAYER_NAME' => $playerName],
            TRUE);

        # SE PLAYER JÁ EXISTE, UPDADE
        if (!Empty($dados)):
            if (empty($id)):
                echo json_encode(['mensagem' => 'Informe o ID do player a ser Atualizado!']);
                http_response_code(406);
                exit;
            endif;

            CrudClass::setTabela('highscore');
            $retorno = CrudClass::update(['score' => $score, 'data' => $date], ['id' => $id, 'playername' => "'" . $playerName . "'"]);
    
            if ($retorno):
                http_response_code(202);
                echo json_encode(['mensagem' => 'Score Atualizado com Sucesso!']);
            else:
                http_response_code(500);
                echo json_encode(['mensagem' => 'Erro ao Atualizar Score!']);
            endif;  
        # SE PLAYER NÃO EXISTE, INSERT
        else:
            CrudClass::setTabela('highscore');
            $retorno = CrudClass::insert(['playername' => "'" . $playerName . "'", 'score' => $score, 'data' => $date]);
        
            if ($retorno):
                http_response_code(201);
                echo json_encode(['mensagem' => 'Novo Score Inserido com Sucesso!']);
            else:            
                http_response_code(500);
                echo json_encode(['mensagem' => 'Erro ao inserir novo Score!']);
            endif;
        endif;
    endif;

    
    // **************** PUT (ALTERAÇÃO) !!!!!!!!!!!!!!!!!!!! NÃO UTILIZADO
    // No INSOMINIA, utilizar o "FORM URL ENCOCODED" (Structured)
    if ($_SERVER['REQUEST_METHOD'] == 'PUT'):
        
        echo json_encode( ['verbo_http' => $_SERVER['REQUEST_METHOD']] );
    
        // PHP NAO POSSUI PUT POR ORIGEM
    //     parse_str(file_get_contents('php://input'), $_PUT);

    //     $id         = (isset($_PUT['id'])) ? $_PUT['id'] : ''                               ;
    //     $playerName = (isset($_PUT['playername'])) ? "'" . $_PUT['playername'] . "'" : ''   ;        
    //     $score      = (isset($_PUT['score']) && $_PUT['score'] > 0) ? $_PUT['score'] : ''   ;
    //     $date       = 'CURDATE()'                                                           ;
    
    //     # Verifies recieved parameters
    //     // echo json_encode( ["ID" => $id, "NOME" => $playerName, "SCORE" => $score]);

    //     if (empty($id)):
    //         echo json_encode(['mensagem' => 'Informe o ID do Player']);
    //         http_response_code(406);
    //         exit;
    //     elseif(empty($playerName)):
    //         echo json_encode(['mensagem' => 'Informe o Nickname do Player']);
    //         http_response_code(406);
    //         exit; 
    //     elseif(empty($score)):
    //         echo json_encode(["mensagem" => "Informe o SCORE a ser atualizado"]);
    //         http_response_code(406);
    //         exit;
    //     endif;

    //     CrudClass::setTabela('highscore');
    //     $retorno = CrudClass::update(['score' => $score, 'data' => $date], ['id' => $id, 'playername' => $playerName]);

    //     if ($retorno):
    //         http_response_code(202);
    //         echo json_encode(['mensagem' => 'Score Atualizado com Sucesso!']);
    //     else:
    //         http_response_code(500);
    //         echo json_encode(['mensagem' => 'Erro ao Atualizar Score!']);
    //     endif;
    endif;
    
    
    // ********************* DELETE !!!!!!!!!!!!!!!!!!!! NÃO UTILIZADO
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE'):
        
        // echo json_encode( ['verbo_http' => $_SERVER['REQUEST_METHOD']] );
    
        // if (!is_numeric($uri)):
        //     echo json_encode(['mensagem' => 'O parâmetro não é numérico']);
        //     http_response_code(406);
        //     exit;
        // else:
        //     $dados = CrudClass::select('SELECT id FROM estoque WHERE id = :id', ['id' => $uri], FALSE);
        //     if (!empty($dados)):
        //         // Exclui da Tabela ESTOQUE
        //         CrudClass::setTabela('estoque');
        //         $retorno = CrudClass::delete(['id' => $uri]);
    
        //         // Exclui da tabela MOVIMENTAÇÃO_ESTOQUE
        //         CrudClass::setTabela('movimentacao_estoque');
        //         $retornoMov = CrudClass::delete(['id_produto' => $uri]);
    
        //         if ($retorno):
        //             http_response_code(202);
        //             echo json_encode(['mensagem' => 'Deletado com sucesso!']);
        //             exit;
        //         else:
        //             http_response_code(500);
        //             echo json_encode(['mensagem' => 'Problema na deleção do cliente!']);
        //             exit;
        //         endif;
        //     else:
        //         http_response_code(404);
        //         echo json_encode(['mensagem' => 'O parâmetro informado não foi encontrado']);
        //         exit;
        //     endif;
        // endif;
    endif;
?>