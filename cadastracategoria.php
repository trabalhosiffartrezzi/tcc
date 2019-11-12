<!DOCTYPE html>
<html>
<head>
	<title>Gerenciar Categorias</title>
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


  #CRUD categoria
   
  $mensagem = "";

  $idcat    = "";
  $nome = "";
  
  if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
	 
	 $acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $idcat     = mysqli_real_escape_string($bd, $_POST["idcat"] ) ;
	    $nome  = mysqli_real_escape_string($bd, $_POST["nome"] ) ;
     }
     
     if (strtoupper($acao) == "INCLUIR") {
		 
		 $sql = "insert into categoria (idcat,nome) values ('$idcat','$nome')";
		                
		 if ( ! mysqli_query($bd, $sql) ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";

		 } else {
		     $descr_acao = "Salvar";

		     $idcat = mysqli_insert_id($bd);
		 }
	 }
	 
	 if (strtoupper($acao) == "SALVAR") {
		 
		 $descr_acao = "Salvar";
		 
		 $sql = " update 
		              categoria 
		          set 
		              nome = '$nome' 
		          where 
		              idcat = '$idcat' ";
		              
		 if ( ! mysqli_query($bd, $sql) ) {
			 
			 $mensagem = "<h3>Ocorreu um erro ao alterar os dados </h3>
			 <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
			 
		 }
	 }

     if (strtoupper($acao) == "EXCLUIR") {
        
        $idcat = $_POST["idcat"];

     	$descr_acao = "Incluir";

     	$sql = "delete from categoria where idcat = $idcat ";

     	if ( ! mysqli_query($bd, $sql) ) {

     		if (mysqli_errno($bd) == 1451) {

     			$mensagem = "Não é possível excluir uma área enquanto houverem prioridades alocadas a ela!";
     		}
		}

     	$idcat = "";
     }

     if (strtoupper($acao) == "BUSCAR") {

        $idcat = $_POST["idcat"];
     	
     	$descr_acao = "Salvar";

     	$sql = "select idcat, nome 
     	        from categoria
     	        where idcat = '$idcat' ";

     	$resultado = mysqli_query($bd, $sql);

     	if (mysqli_num_rows($resultado) == 1) {

             $dados = mysqli_fetch_assoc($resultado);

             $idcat    = $dados["idcat"];
             $nome = $dados["nome"];
     	}
     }
   }
	 
   $sql_listar = "select idcat, nome from categoria order by nome";
	 
   $lista = mysqli_query($bd, $sql_listar);
	 
   if ( mysqli_num_rows($lista) > 0 ) {
		
		$tabela = "<table border='1'>";
		
		$tabela = $tabela."<tr><th>Código</th><th>Categoria</th>
		             <th>Alterar</th><th>Excluir</th></tr>";
		 
		while ( $dados = mysqli_fetch_assoc($lista) ) {
		   
		   $vidcat     = $dados["idcat"];
		   $vnome  = $dados["nome"];
	   
		   $alterar = "<form method='post'>
		                  <input type='hidden' name='idcat' value='$vidcat'>
		                  <input type='hidden' name='acao' value='BUSCAR'>
		                  <input type='image' src='./img/editar.png'> 
		               </form>";
		   
		   $excluir = "<form method='post'>
		                  <input type='hidden' name='idcat' value='$vidcat'>
		                  <input type='hidden' name='acao' value='EXCLUIR'>
		                  <input type='image' src='./img/deletar.png'>
		                  
		               </form>";
		   
		   $tabela = $tabela."<tr><td>$vidcat</td><td>$vnome</td>
		        <td>$alterar</td><td>$excluir</td></tr>";
		}
		
		$tabela = $tabela."</table>"; 
   } else 
	    $tabela = "não há dados para listar";
	    
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
<div class="container-fluid col-md-6">
  <form action="cadastracategoria.php" method="post">
  <div class="form-group ">
    <h2>Cadastro de Categoria</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idcat" value="<?php echo $idcat;?>">
    </div>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nome" value="<?php echo $nome;?>" placeholder="Nome da categoria">
    </div>
    <br>
    <br>
  <div class="form-group row">
    <div class="col-sm-10">
      <input type="submit" class="btn btn-primary" value="Novo">
      <input type="submit" class="btn btn-secondary" name="acao" value="<?php echo $descr_acao; ?>">
    </div>
  </div>
</form>
</div>
<div class="container">
 	<fieldset>
	<legend>Categorias  Cadastradas</legend>
	
	   <?php echo $tabela; ?>
	
	</fieldset>
</div>


</body>
</html>