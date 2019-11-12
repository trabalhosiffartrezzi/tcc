<!DOCTYPE html>
<html>
<head>
  <title>Gerenciar Usuários</title>

  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  
  <?php 

  session_start();

  if (isset($_SESSION["cpf_cnpj"]) && isset($_SESSION["iduser"] )) {
    $cpf_cnpjv = $_SESSION["cpf_cnpj"];
    $iduserv = $_SESSION["iduser"];
  } else{
    header('location:index.php?Erro ao acessar os dados');
  }
  ?>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

  <script src="https://kit.fontawesome.com/5227edd223.js" crossorigin="anonymous"></script>

  <script type="text/javascript" src="mascara/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="mascara/jquery.mask.min.js"></script>

  <script type="text/javascript">

    
    $(document).on('keydown', '[data-mask-for-cpf-cnpj]', function (e) {

    var digit = e.key.replace(/\D/g, '');

    var value = $(this).val().replace(/\D/g, '');

    var size = value.concat(digit).length;

    $(this).mask((size <= 11) ? '000.000.000-00' : '00.000.000/0000-00');

  });

    $(document).on('keydown', '[data-mask-for-phone]', function (e) {

    var digit = e.key.replace(/\D/g, '');

    var value = $(this).val().replace(/\D/g, '');

    var size = value.concat(digit).length;

    $(this).mask((size <= 10) ? '(00)0000-0000' : '(00)00000-0000');

  });
 

  </script>

</head>
<body>

  <?php
  $bd = mysqli_connect("localhost","root","","tcc");

   if($bd){ 
         mysqli_set_charset($bd, "utf8");
   }else{
         echo "Não foi possível conectar o BD <br>";
         echo "Mensagem de erro: ".mysqli_connect_error() ;
   exit();
      }


  #CRUD Produtos
  $mensagem = "";

  $iduser    = "";
  $nome = "";
  $telefone = "";
  $cpf_cnpj = "";
  $email = "";
  $enderecoid = "";
  $idenderec = "";
  $rua = "";
  $bairro = "";
  $numero = "";
  $complemento = "";
  $cidadeid = "";
  
  if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
   
   $acao = $_POST["acao"];
   
   if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
      $iduser     = mysqli_real_escape_string($bd, $_POST["iduser"] ) ;
      $nome  = mysqli_real_escape_string($bd, $_POST["nome"] ) ;
      $telefone  = mysqli_real_escape_string($bd, $_POST["telefone"] ) ;
      $cpf_cnpj  = mysqli_real_escape_string($bd, $_POST["cpf_cnpj"] ) ;
      $email  = mysqli_real_escape_string($bd, $_POST["email"] ) ;
      $idenderec  = mysqli_real_escape_string($bd, $_POST["idenderec"] ) ;
      $rua  = mysqli_real_escape_string($bd, $_POST["rua"] ) ;
      $bairro  = mysqli_real_escape_string($bd, $_POST["bairro"] ) ;
      $numero  = mysqli_real_escape_string($bd, $_POST["numero"] ) ;
      $complemento  = mysqli_real_escape_string($bd, $_POST["complemento"] ) ; 
      $cidadeid  = mysqli_real_escape_string($bd, $_POST["cidadeid"] ) ;
     }

     if (strtoupper($acao) == "INCLUIR") {
      
      ##Checa se o campo e nulo
      if ($idenderec == false){

        $sql = "insert into endereco (rua,bairro,numero,complemento,cidadeid) values ('$rua','$bairro',$numero,'$complemento',$cidadeid);";
        ##insere os dados na tabela endereco
       $result1 = mysqli_query($bd, $sql);

        ##recupera a ultima chave da tabela endereco
        $chave_estrangeira =  " select idenderec from endereco order by idenderec desc limit 1";
        
        $chave = mysqli_query($bd,$chave_estrangeira);
        $chave = mysqli_fetch_array($chave);
      
         ##insere a chave recuperada na tabela usuario
        $sql2 = "insert into usuario(nome, telefone, cpf_cnpj, email, enderecoid) values ( '$nome','$telefone','$cpf_cnpj', '$email', ".$chave['idenderec'].");";

        $result2 = mysqli_query($bd, $sql2 );
      
      }
                    
     if ( !$result1 && !$result2  ) {

          $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
                    <h3>Erro: ".mysqli_error($bd)."</h3>
                    <h3>Código: ".mysqli_errno($bd)."</h3>";
         
            $descr_acao = "Incluir";

     } else {
         $descr_acao = "Salvar";

         $iduser = mysqli_insert_id($bd);
     }
   }
   
   if (strtoupper($acao) == "SALVAR") {
     
     $descr_acao = "Salvar";
     
     $sql = " update 
                  endereco, cidade
              set 
                  endereco.rua = '$rua',
                  endereco.bairro = '$bairro',
                  endereco.numero = $numero,
                  endereco.complemento = '$complemento',
                  endereco.cidadeid = $cidadeid
              where 
                  cidade.idcidade = endereco.cidadeid and
                  endereco.idenderec = $idenderec ";

      $sql2 = " update
                  usuario
                set
                  nome = '$nome',
                  telefone = '$telefone',
                  cpf_cnpj = '$cpf_cnpj',
                  email = '$email',
                  enderecoid = $idenderec
                where
                  iduser = $iduser ";

                  
     if ( ! mysqli_query($bd, $sql2) &&  ! mysqli_query($bd, $sql) ) {
       
       $mensagem = "<h3>Ocorreu um erro ao alterar os dados </h3>
       <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
       
     }
   }

     if (strtoupper($acao) == "EXCLUIR") {
        
      $iduser = $_POST["iduser"];

      $descr_acao = "Incluir";

      $delete = " select * from usuario where iduser = $iduser";

      $resultado = mysqli_query($bd, $delete);

      $resultado = mysqli_fetch_array($resultado);

      $sql2 = "delete from endereco where idenderec = ".$resultado['enderecoid'];
      $sql = "delete from usuario where iduser = $iduser ";
      
      $result3 = mysqli_query($bd, $sql);
      $result4 = mysqli_query($bd, $sql2);
      
      if ( !$result3  && !$result4  ) {

        if (mysqli_errno($bd) == 1451) {

          $mensagem = "Não é possível excluir uma usuario enquanto houverem endereços cadastrados a ele!";
        }
    }

      $idenderec = "";
      $iduser = "";
     }

     if (strtoupper($acao) == "BUSCAR") {

      $iduser = $_POST["iduser"];
      

      $descr_acao = "Salvar";

      $sql = "select iduser, nome, telefone, cpf_cnpj, email, enderecoid 
              from usuario
              where iduser = '$iduser' ";
             
      $resultado2 = mysqli_query($bd, $sql);
      $user = mysqli_fetch_array($resultado2);

      $sql2 = "select idenderec, rua, bairro, numero, complemento, cidadeid 
              from endereco
              where idenderec = ".$user['enderecoid'];  
              

      $resultado = mysqli_query($bd, $sql2);

      if (mysqli_num_rows($resultado) == 1 && mysqli_num_rows($resultado2) == 1) {

             $dados = mysqli_fetch_assoc($resultado);

             $idenderec    = $dados["idenderec"];
             $rua = $dados["rua"];
             $bairro = $dados["bairro"];
             $numero = $dados["numero"];
             $complemento = $dados["complemento"];
             $cidadeid = $dados["cidadeid"];
             $iduser = $user["iduser"];
             $nome = $user["nome"];
             $telefone = $user["telefone"];
             $funcao = $user["funcao"];
             $senha = $user["senha"];
             $cpf_cnpj = $user["cpf_cnpj"];
             $email = $user["email"];
             $enderecoid = $user["enderecoid"];

      }
     }
   }
   
    ?>
<div class="container w-70">
    <ul class="nav justify-content-center">
      <?php 
      $bd = mysqli_connect("localhost","root","","tcc");

        if($bd){ 
          mysqli_set_charset($bd, "utf8");
        }else{
            echo "Não foi possível conectar o BD <br>";
            echo "Mensagem de erro: ".mysqli_connect_error() ;
        exit();
          }

      $sqlusuario ="select iduser, nome from usuario where iduser=$iduserv";

      $resultado = mysqli_query($bd,$sqlusuario);

      $dados = mysqli_fetch_array($resultado);

      ?>
        <a class="nav-link" href="painelvendedor.php"><i class="fas fa-undo-alt"></i>Voltar</i></a>
        <a class="nav-link disabled"><i class="fas fa-user"><?php echo $dados["nome"] ?></i></a>
        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
      </ul>
  </div>
 <div class="container w-70">
 <form action="cadastrarclientesvendedor.php" method="post">
  <div class="form-group ">
    <h2>Cadastro de Usuários</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="iduser" value="<?php echo $iduser;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Nome</label> 
      <input type="text" class="form-control" name="nome" value="<?php echo $nome;?>" placeholder="Nome">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Telefone</label> 
      <input type="text" data-mask-for-phone class="form-control" name="telefone" value="<?php echo $telefone;?>" placeholder="Telefone (com DDD)">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">CPF ou CNPJ</label> 
      <input type="text" data-mask-for-cpf-cnpj class="form-control" name="cpf_cnpj" value="<?php echo $cpf_cnpj;?>" placeholder="CPF ou CNPJ">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Email</label> 
      <input type="text" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Email">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idenderec" value="<?php echo $idenderec;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Rua</label> 
      <input type="text" class="form-control" name="rua" value="<?php echo $rua;?>" placeholder="Rua">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Bairro</label> 
      <input type="text" class="form-control" name="bairro" value="<?php echo $bairro;?>" placeholder="Bairro">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Numero</label> 
      <input type="text" class="form-control" name="numero" value="<?php echo $numero;?>" placeholder="Numero">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Complemento</label> 
      <input type="text" class="form-control" name="complemento" value="<?php echo $complemento;?>" placeholder="complemento">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
        <label form="inputNome">Cidade</label>      
          <select class="form-control"  name="cidadeid">
                 
          <?php 

       $result = "select idcidade, nomecidade from cidade";
       $resultado = mysqli_query($bd, $result);

       while($row = mysqli_fetch_assoc($resultado)) {
          if($row['idcidade'] == $cidadeid) echo '<option selected value="'.$row['idcidade'].'"> '.$row['nomecidade'].' </option>';
          else echo '<option value="'.$row['idcidade'].'"> '.$row['nomecidade'].' </option>';
         
       }
          ?>
                 
            </select>
      </div>
    <br>
    <br>
    <div class="form-group row">
    <div class="col-sm-10">
      <input type="submit" class="btn btn-primary" value="Novo">
      <input type="submit" class="btn btn-secondary" name="acao" value="<?php echo $descr_acao; ?>">
    </div>
    </div>
  </div>  
</form>
</div>
<br>

<div class="container">
  <?php

  if (isset($result1) == true && isset($result1) == true) {
    echo '<div class="alert alert-success" role="alert">
            Cliente cadastrado com sucesso!
          <a class="nav-link active" href="painelvendedor.php">Clique aqui para retornar ao painel</a>
          </div>';
           }
  ?>
</div>

</div>
</body>
</html>
<?php
  
  mysqli_close($bd);

?>