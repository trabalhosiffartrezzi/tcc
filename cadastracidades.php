<!DOCTYPE html>
<html>
<head>
	<title>Gerenciar Cidades</title>
	
	<?php 
		include_once("painel.php")
 
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
   exit();
      }


  #CRUD Cidades
  $mensagem = "";

  $idcidade    = "";
  $nomecidade = "";
  $estadoid = "";
  
  
  if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
	 
	 $acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $idcidade     = mysqli_real_escape_string($bd, $_POST["idcidade"] ) ;
	    $nomecidade  = mysqli_real_escape_string($bd, $_POST["nomecidade"] ) ;
	    $estadoid = mysqli_real_escape_string($bd, $_POST["estadoid"] ) ;
     }
     
     if (strtoupper($acao) == "INCLUIR") {
		 
		 $sql = "insert into cidade (idcidade,nomecidade,estadoid) values ('$idcidade','$nomecidade','$estadoid')";
		                
		 if ( ! mysqli_query($bd, $sql) ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";

		 } else {
		     $descr_acao = "Salvar";

		     $idcidade = mysqli_insert_id($bd);
		 }
	 }
	
	 if (strtoupper($acao) == "SALVAR") {
		 
		 $descr_acao = "Salvar";
		 
		 $sql = " update 
		              cidade 
		          set 
		              nomecidade = '$nomecidade'
		              estadoid = '$estadoid' 
		          where 
		              idcidade = '$idcidade' ";
		              
		 if ( ! mysqli_query($bd, $sql) ) {
			 
			 $mensagem = "<h3>Ocorreu um erro ao alterar os dados </h3>
			 <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
			 
		 }
	 }

     if (strtoupper($acao) == "EXCLUIR") {
        
      $idcidade = $_POST["idcidade"];

     	$descr_acao = "Incluir";

     	$sql = "delete from cidade where idcidade = $idcidade ";

     	if ( ! mysqli_query($bd, $sql) ) {

     		if (mysqli_errno($bd) == 1451) {

     			$mensagem = "Não é possível excluir uma cidade enquanto houverem estados alocados";
     		}
		}

     	$idcidade = "";
     }

     if (strtoupper($acao) == "BUSCAR") {

        $idcidade = $_POST["idcidade"];
     	
     	$descr_acao = "Salvar";

     	$sql = "select idcidade, nomecidade, estadoid 
     	        from cidade
     	        where idcidade = '$idcidade' ";

     	$resultado = mysqli_query($bd, $sql);

     	if (mysqli_num_rows($resultado) == 1) {

             $dados = mysqli_fetch_assoc($resultado);

             $idcidade    = $dados["idcidade"];
             $nomecidade = $dados["nomecidade"];
             $estadoid = $dados["estadoid"];
     	}
     }
   }
	 
   $sql_listar = "select cidade.idcidade, cidade.nomecidade, cidade.estadoid, estado.idestado, estado.nome
   			from 
   				cidade, estado
   			where
   				cidade.estadoid = estado.idestado
   			order by cidade.nomecidade";
	 
   $lista = mysqli_query($bd, $sql_listar);
	 
   if ( mysqli_num_rows($lista) > 0 ) {
		
		$tabela = "<table class='table table-striped'>";
		
		$tabela = $tabela."<tr><th>Código</th><th>Cidades</th><th>Estado</th><th>Alterar</th><th>Excluir</th></tr>";
		 
		while ( $dados = mysqli_fetch_assoc($lista) ) {
		   
		   $vidcidade     = $dados["idcidade"];
		   $vnomecidade  = $dados["nomecidade"];
		   $vestadoid  = $dados["estadoid"];
       $videstado = $dados ["idestado"];
       $vnome = $dados["nome"];
		   
	   
		   $alterar = "<form method='post'>
		                  <input type='hidden' name='idcidade' value='$vidcidade'>
		                  <input type='hidden' name='acao' value='BUSCAR'>
		                  <input type='image' src='./img/editar.png'> 
		               </form>";
		   
		   $excluir = "<form method='post'>
		                  <input type='hidden' name='idcidade' value='$vidcidade'>
		                  <input type='hidden' name='acao' value='EXCLUIR'>
		                  <input type='image' src='./img/deletar.png'>
		                  
		               </form>";
		   
		   $tabela = $tabela."<tr><td>$vidcidade</td><td>$vnomecidade</td><td>$vnome</td><td>$alterar</td><td>$excluir</td></tr>";
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
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt">Sair</i></a> 
      </ul>
  </div>  
 <div class="container col-md-6">
 <form action="cadastracidades.php" method="post">
  <div class="form-group ">
    <h2>Cadastro de Cidades para o Brasil</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idcidade" value="<?php echo $idcidade;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Nome da Cidade</label> 
      <input type="text" class="form-control" name="nomecidade" value="<?php echo $nomecidade;?>" placeholder="Nome da Cidade">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
        <label form="inputNome">Categoria</label>      
          <select class="form-control"  name="estadoid">
                 
          <?php 

       $result = "select idestado, nome from estado order by nome";
       $resultado = mysqli_query($bd, $result);

       while($row = mysqli_fetch_assoc($resultado)) {
         echo '<option value="'.$row['idestado'].'"> '.$row['nome'].' </option>';
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

<fieldset>
<legend>Produtos  Cadastrados</legend>
	
	   <?php echo $tabela; ?>
	
</fieldset>

</div>

</body>

</html>
