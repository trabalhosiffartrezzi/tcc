<!DOCTYPE html>
<html>
<head>
	<title>Gerenciar Produtos</title>
	
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


  #CRUD Produtos
  $mensagem = "";

  $idprod    = "";
  $nomeprod = "";
  $descricao = "";
  $valor = "";
  $unidade = "";
  $categoriaid = "";
  
  if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
	 
	 $acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $idprod     = mysqli_real_escape_string($bd, $_POST["idprod"] ) ;
	    $nomeprod  = mysqli_real_escape_string($bd, $_POST["nomeprod"] ) ;
	    $descricao  = mysqli_real_escape_string($bd, $_POST["descricao"] ) ;
	    $valor  = mysqli_real_escape_string($bd, $_POST["valor"] ) ;
	    $unidade  = mysqli_real_escape_string($bd, $_POST["unidade"] ) ;
	    $categoriaid  = mysqli_real_escape_string($bd, $_POST["categoriaid"] ) ;
     }

     if (strtoupper($acao) == "INCLUIR") {
		 
		 $sql = "insert into produto (nomeprod,descricao,valor,unidade,categoriaid) values ('$nomeprod','$descricao',$valor,'$unidade','$categoriaid')";
		                
		 if ( ! mysqli_query($bd, $sql) ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";

		 } else {
		     $descr_acao = "Salvar";

		     $idprod = mysqli_insert_id($bd);
		 }
	 }

	 if (strtoupper($acao) == "SALVAR") {
		 
		 $descr_acao = "Salvar";
		 
		 $sql = " update 
		              produto, categoria 
		          set 
		              produto.nomeprod = '$nomeprod',
		              produto.descricao = '$descricao',
		              produto.valor = $valor,
		              produto.unidade = '$unidade',
		              produto.categoriaid = '$categoriaid' 
		          where 
                  produto.categoriaid = categoria.idcat and
		              idprod = $idprod ";

		              
		 if ( ! mysqli_query($bd, $sql) ) {
			 
			 $mensagem = "<h3>Ocorreu um erro ao alterar os dados </h3>
			 <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
			 
		 }
	 }

     if (strtoupper($acao) == "EXCLUIR") {
        
        $idprod = $_POST["idprod"];

     	$descr_acao = "Incluir";

     	$sql = "delete from produto where idprod = $idprod ";

     	if ( ! mysqli_query($bd, $sql) ) {

     		if (mysqli_errno($bd) == 1451) {

     			$mensagem = "Não é possível excluir um produto enquanto houverem categorias alocadas a ele!";
     		}
		}

     	$idprod = "";
     }

     if (strtoupper($acao) == "BUSCAR") {

      $idprod = $_POST["idprod"];
     	
     	$descr_acao = "Salvar";

     	$sql = "select idprod, nomeprod, descricao, valor, unidade, categoriaid 
     	        from produto
     	        where idprod = $idprod ";

     	$resultado = mysqli_query($bd, $sql);

     	if (mysqli_num_rows($resultado) == 1) {

             $dados = mysqli_fetch_assoc($resultado);

             $idprod    = $dados["idprod"];
             $nomeprod = $dados["nomeprod"];
             $descricao = $dados["descricao"];
             $valor = $dados["valor"];
             $unidade = $dados["unidade"];
             $categoriaid = $dados["categoriaid"];
     	}
     }
   }
	 
   $sql_listar = "select produto.idprod, produto.nomeprod, produto.descricao, produto.valor, produto.unidade, produto.categoriaid, categoria.idcat, categoria.nome 
   			from 
   				produto, categoria 
   			where
   				produto.categoriaid = categoria.idcat
   			order by produto.nomeprod";
	 
   $lista = mysqli_query($bd, $sql_listar);
	 
   if ( mysqli_num_rows($lista) > 0 ) {
		
		$tabela = "<table class='table table-striped'>";
		
		$tabela = $tabela."<tr><th>Código</th><th>Nome</th><th>Descricao</th><th>Valor</th><th>Unidade</th><th>Categoria</th>
		             <th>Alterar</th><th>Excluir</th></tr>";
		 
		while ( $dados = mysqli_fetch_assoc($lista) ) {
		   
		   $vidprod     = $dados["idprod"];
		   $vnomeprod  = $dados["nomeprod"];
		   $vdescricao  = $dados["descricao"];
		   $vvalor = $dados["valor"];
		   $vunidade  = $dados["unidade"];
		   $vcategoriaid  = $dados["categoriaid"];
		   $vidcat     = $dados["idcat"];
		   $vnome     = $dados["nome"];
	   
		   $alterar = "<form method='post'>
		                  <input type='hidden' name='idprod' value='$vidprod'>
		                  <input type='hidden' name='acao' value='BUSCAR'>
		                  <input type='image' src='./img/editar.png'> 
		               </form>";
		   
		   $excluir = "<form method='post'>
		                  <input type='hidden' name='idprod' value='$vidprod'>
		                  <input type='hidden' name='acao' value='EXCLUIR'>
		                  <input type='image' src='./img/deletar.png'>
		                  
		               </form>";
		   
		   $tabela = $tabela."<tr><td>$vidprod</td><td>$vnomeprod</td><td>$vdescricao</td><td>$vvalor</td><td>$vunidade</td><td>$vnome</td>
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
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt">Sair</i></a> 
      </ul>
  </div>  
 <div class="container w-70">
 <form action="cadastraproduto.php" method="post">
  <div class="form-group ">
    <h2>Cadastro de Produtos</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idprod" value="<?php echo $idprod;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Mome do Produto</label> 
      <input type="text" class="form-control" name="nomeprod" value="<?php echo $nomeprod;?>" placeholder="Nome da produto">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Descricao do Produto</label>
      <input type="text" class="form-control" name="descricao" value="<?php echo $descricao;?>" placeholder="Descricao">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Valor</label>
      <input type="text" class="form-control" name="valor" value="<?php echo $valor;?>" placeholder="Valor">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Unidade</label>
      <input type="text" class="form-control" name="unidade" value="<?php echo $unidade;?>" placeholder="Nome da categoria">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
        <label form="inputNome">Categoria</label>      
          <select class="form-control"  name="categoriaid">
                 
          <?php 

       $result = "select idcat, nome from categoria";
       $resultado = mysqli_query($bd, $result);

       while($row = mysqli_fetch_assoc($resultado)) {
          if($row['idcat'] == $categoriaid) echo '<option selected value="'.$row['idcat'].'"> '.$row['nome'].' </option>';
          else echo '<option value="'.$row['idcat'].'"> '.$row['nome'].' </option>';
         
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

<div class="container">
  <fieldset>
    <legend>Produtos  Cadastrados</legend>
  
     <?php echo $tabela; ?>
  
  </fieldset>
</div>


</div>

</body>
</html>
<?php
  
  mysqli_close($bd);

?>