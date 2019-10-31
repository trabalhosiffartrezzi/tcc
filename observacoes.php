<!DOCTYPE html>
<html>
<head>
	<title>Observações do pedido</title>
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
   	exit();}

   	$observacoes = "";
   	$vtotal ="";

   	 if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
	 
	 $acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $observacoes     = mysqli_real_escape_string($bd, $_POST["observacoes"] ) ;
     }

     if (strtoupper($acao) == "INCLUIR") {
		 
		 $sqlupdate = " update venda_pedido
		 set observacoes = '$observacoes'
		 where uservendedorid = $iduserv 
		 order by 
		 idvendap desc limit 1";

		 $update = mysqli_query($bd,$sqlupdate);
		                
		 if ( ! $update ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";
	 		}else{$descr_acao = "Salvar";

		     $idvendap = mysqli_insert_id($bd);}
		}
	}

	$sql_chave="select idvendap from venda_pedido where uservendedorid = $iduserv  order by idvendap desc limit 1";

	$consulta_chave = mysqli_query($bd, $sql_chave);

	$chave = mysqli_fetch_array($consulta_chave);

    $armazena1 =$chave[0];

	$sqltotalpe = "select sum(total_un) from venda_produto where vendapid =".$armazena1.";";

    $total = mysqli_query($bd, $sqltotalpe);

    $totalpe = mysqli_fetch_array($total);

    $armazena2 =$totalpe[0]; 

    $sqlinsert = "update venda_pedido
    	set vtotal =".$armazena2."
    	where uservendedorid = $iduserv";

    $insert = mysqli_query($bd, $sqlinsert);
	
	?>


  <div class="container w-70">
      <ul class="nav justify-content-end">
        <a class="nav-link disabled"><i class="fas fa-user">Nome Usuário</i></a>
        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
      </ul>
  </div>
 <div class="container w-70">
 <form action="observacoes.php" method="post">
  <div class="form-group ">
    <h2>Observações</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idvendap" value="<?php echo $idvendap;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Observações</label> 
      <textarea class="form-control" name="observacoes" value="<?php echo $observacoes;?>" placeholder="observacoes"></textarea> 
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
<?php

  if (isset($update) == true) {
    echo '<div class="alert alert-success" role="alert">
            Observação inserida! 
          <a class="nav-link active" href="painelvendedor.php">Clique aqui para finalizar o pedido</a>
          </div>';
           }
  ?>
</div>

<div class="container w-70">
<a href="inserirprodutos.php"><i class="fas fa-backward fa-lg">Voltar</i></a>
</div>

</body>
</html>