<!DOCTYPE html>
<html>
<head>
	<title>Observações do pedido</title>
	<?php
	include_once("painel.php");
	?>
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
		 idvp desc limit 1";

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

	$sqltotalpe = "select sum(total_un) from venda_produto;";

    $total = mysqli_query($bd, $sqltotalpe);

    $totalpe = mysqli_fetch_array($total);

    $armazena =$totalpe[0]; 

    $sqlinsert = "update venda_pedido
    	set vtotal =".$armazena."
    	where uservendedorid = $iduserv";

    $insert = mysqli_query($bd, $sqlinsert);
	
	?>


 <div class="container col-md-6">
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
          <a class="nav-link active" href="painel.php">Clique aqui para finalizar o pedido</a>
          </div>';
           }
  ?>
</div>

</body>
</html>