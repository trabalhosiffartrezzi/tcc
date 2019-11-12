<!DOCTYPE html>
<html>
<head>
	<title>Gerenciamento de Pagamentos</title>
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

  $idpgto    = "";
  $condicaopgto = "";
  $prazopgto	 = "";
  $desconto = "";
  $observacao = "";
  $vendapid ="";
  
  if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
	 
	 $acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $idpgto     = mysqli_real_escape_string($bd, $_POST["idpgto"] ) ;
	    $condicaopgto  = mysqli_real_escape_string($bd, $_POST["condicaopgto"] ) ;
	    $prazopgto  = mysqli_real_escape_string($bd, $_POST["prazopgto"] ) ;
	    $desconto  = mysqli_real_escape_string($bd, $_POST["desconto"] ) ;
	    $observacao  = mysqli_real_escape_string($bd, $_POST["observacao"] ) ;
	    $vendapid  = mysqli_real_escape_string($bd, $_POST["vendapid"] ) ;
     }

     if (strtoupper($acao) == "INCLUIR") {
		 
		 $sql = "insert into pagamento (vendapid, condicaopgto, prazopgto, desconto, observacao) values ($vendapid ,'$condicaopgto','$prazopgto','$desconto','$observacao' );";

		                
		 if ( ! mysqli_query($bd, $sql) ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";

		 } else {
		     $descr_acao = "Salvar";

		     $idpgto = mysqli_insert_id($bd);
		 }
	 }

	 if (strtoupper($acao) == "SALVAR") {
		 
		 $descr_acao = "Salvar";
		 
		 $sql = " update 
		              pagamento 
		          set 
		              condicaopgto = '$condicaopgto',
		              prazopgto = '$prazopgto',
		              desconto = '$desconto',
		              observacao = '$observacao',
		              vendapid = $vendapid 
		          where 
                  	idpgto=$idpgto;";

		              
		 if ( ! mysqli_query($bd, $sql) ) {
			 
			 $mensagem = "<h3>Ocorreu um erro ao alterar os dados </h3>
			 <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
			 
		 }
	 }

     if (strtoupper($acao) == "EXCLUIR") {
        
        $idpgto = $_POST["idpgto"];

     	$descr_acao = "Incluir";

     	$sql = "delete from pagamento where idpgto = $idpgto ";

     	if ( ! mysqli_query($bd, $sql) ) {

     		if (mysqli_errno($bd) == 1451) {

     			$mensagem = "Não é possível excluir um pagamento enquanto houverem pedidos alocados a ele!";
     		}
		}

     	$idpgto = "";
     }

     if (strtoupper($acao) == "BUSCAR") {

        $idpgto = $_POST["idpgto"];
     	
     	$descr_acao = "Salvar";

     	$sql = "select idpgto, condicaopgto, prazopgto, desconto, observacao, vendapid 
     	        from pagamento
     	        where idpgto = $idpgto ";

     	$resultado = mysqli_query($bd, $sql);

     	if (mysqli_num_rows($resultado) == 1) {

             $dados = mysqli_fetch_assoc($resultado);

             $idpgto    = $dados["idpgto"];
             $condicaopgto = $dados["condicaopgto"];
             $prazopgto = $dados["prazopgto"];
             $desconto = $dados["desconto"];
             $observacao = $dados["observacao"];
             $vendapid = $dados["vendapid"];
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
        <a class="nav-link" href="paineladm.php"><i class="fas fa-undo-alt"></i>Voltar</i></a>
        <a class="nav-link disabled"><i class="fas fa-user"><?php echo $dados["nome"] ?></i></a>
        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
      </ul>
  </div>
 <div class="container w-70">
 <form action="cadastrapagamento.php" method="post">
  <div class="form-group ">
    <h2>Cadastro de Produtos</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idpgto" value="<?php echo $idpgto;?>">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
        <label form="inputNome">Pedidos Cadastrados</label>      
          <select class="form-control"  name="vendapid">
                 
          <?php 

       $result = "select venda_pedido.idvendap, venda_pedido.userclienteid, venda_pedido.uservendedorid, 	usuario.iduser, usuario.nome 
       		from venda_pedido, usuario 
       		where usuario.iduser = venda_pedido.userclienteid ";
       
       $resultado = mysqli_query($bd, $result);

       while($row = mysqli_fetch_assoc($resultado)) {
          if($row['idvendap'] == $vendapid) echo '<option selected value="'.$row['idvendap'].'">'.'Cod. do pedido: '.$row['idvendap'].'----'.'Cliente: '.$row['nome'].' </option>';
          else echo '<option value="'.$row['idvendap'].'"> '.'Cod. do pedido: '.$row['idvendap'].'----'.'Cliente: '.$row['nome'].'</option>'; 
       }
          ?>     
            </select>
    	</div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Condição de Pagamento</label> 
      <input type="text" class="form-control" name="condicaopgto" value="<?php echo $condicaopgto;?>" placeholder="Condição de Pagamento">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Prazo para Pagamento</label>
      <input type="text" class="form-control" name="prazopgto" value="<?php echo $prazopgto;?>" placeholder="Prazo para pagamento">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Desconto</label>
      <input type="text" class="form-control" name="desconto" value="<?php echo $desconto;?>" placeholder="Desconto">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Observação</label>
      <input type="text" class="form-control" name="observacao" value="<?php echo $observacao;?>" placeholder="Observação">
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

</body>
</html>