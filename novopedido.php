<!DOCTYPE html>
<html>
<head>
	<title>Faça seu pedido aqui!</title>
	
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

 $mensagem = "";

 $idvendap = "";
 $userclienteid = "";
 $uservendedorid = "";
 $enderecoid = "";
  
  if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
	 
	 $acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $idvendap     = mysqli_real_escape_string($bd, $_POST["idvendap"] ) ;
	    $userclienteid  = mysqli_real_escape_string($bd, $_POST["userclienteid"] ) ;
	    $uservendedorid  = mysqli_real_escape_string($bd, $_POST["uservendedorid"] ) ;
	    $enderecoid  = mysqli_real_escape_string($bd, $_POST["enderecoid"] ) ;
     }

     if (strtoupper($acao) == "INCLUIR") {
		 
		 $sqlinsert = "insert into venda_pedido (userclienteid , uservendedorid ,enderecoid) values ($userclienteid,$uservendedorid, $enderecoid)";
		                
		 if ( ! mysqli_query($bd, $sqlinsert) ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";

		 } else {
		     $descr_acao = "Salvar";

		     $idvendap = mysqli_insert_id($bd);
		 }
	 }
	 
  
	 if (strtoupper($acao) == "SALVAR") {
		 
		 $descr_acao = "Salvar";
		 
		 $sql = " update 
		              venda_pedido 
		          set 
		              userclienteid = $userclienteid,
		              uservendedorid = $uservendedorid,
		              enderecoid = $enderecoid
		          where 
                  		idvendap = $idvendap";

		              
		 if ( ! mysqli_query($bd, $sql) ) {
			 
			 $mensagem = "<h3>Ocorreu um erro ao alterar os dados </h3>
			 <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
			 
		 }
	 }

     if (strtoupper($acao) == "EXCLUIR") {
        
        $idvendap = $_POST["idvendap"];

     	$descr_acao = "Incluir";

     	$sql = "delete from venda_pedido where idvendap = $idvendap ";

     	if ( ! mysqli_query($bd, $sql) ) {

     		if (mysqli_errno($bd) == 1451) {

     			$mensagem = "Não é possível excluir uma área enquanto houverem prioridades alocadas a ela!";
     		}
		}

     	$idvendap = "";
     }

     if (strtoupper($acao) == "BUSCAR") {

        $idvendap = $_POST["idvendap"];
     	
     	$descr_acao = "Salvar";

     	$sql = "select idvendap, userclienteid, uservendedorid, enderecoid 
     	        from venda_pedido
     	        where idvendap = $idvendap ";

     	$resultado = mysqli_query($bd, $sql);

     	if (mysqli_num_rows($resultado) == 1) {

             $dados = mysqli_fetch_assoc($resultado);

             $idvendap    = $dados["idvendap"];
             $userclienteid = $dados["userclienteid"];
             $uservendedorid = $dados["uservendedorid"];
             $enderecoid = $dados["enderecoid"];
     	}
     }
   } 
?>

<div class="container w-70">
      <ul class="nav justify-content-center">
        <a class="nav-link" href="painelvendedor.php"><i class="fas fa-backward ">Voltar</i></a>
        <a class="nav-link disabled"><i class="fas fa-user">Nome Usuário</i></a>
        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
      </ul>
</div>
  <br>
  <br>
<div class="container w-70">
 <form action="novopedido.php" method="post">
  <div class="form-group w-70">
    <h2>Insira os dados abaixo</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idvendap" value="<?php echo $idvendap;?>">
    </div>
    
    <div class="col-sm-10">
        <label form="inputNome">Cliente</label>      
          <select class="form-control"  name="userclienteid">
                 
          <?php 

       $result3 = "select iduser, nome from usuario";
       $resultado3 = mysqli_query($bd, $result3);

       while($row = mysqli_fetch_array($resultado3)) {
          if($row['iduser'] == $userclienteid) echo '<option selected value="'.$row['iduser'].'"> '.$row['nome'].' </option>';
          else echo '<option value="'.$row['iduser'].'"> '.$row['nome'].' </option>';
       }
          ?>
            </select>
    	</div>
    <br>
    <br>
    
    <div class="col-sm-10">
        <label form="inputNome">Endereço de Entrega</label>      
          <select class="form-control"  name="enderecoid">
                 
          <?php 

       $result1 = 
       "select usuario.enderecoid, endereco.idenderec, endereco.rua, endereco.bairro, endereco.numero, endereco.complemento, cidade.idcidade, cidade.nomecidade, estado.idestado, estado.sigla
       from 
       		usuario, endereco, cidade, estado 
       where 
       		usuario.enderecoid = endereco.idenderec and
       		endereco.cidadeid = cidade.idcidade and 
       		cidade.estadoid = estado.idestado
       	order by
       		usuario.enderecoid";
       
       $resultado1 = mysqli_query($bd, $result1);

       while($row = mysqli_fetch_array($resultado1)) {
          if($row['idenderec'] == $userclienteid) echo '<option selected value="'.$row['idenderec'].'"> '.$row['rua'].'-'.$row['bairro'].'-'.$row['numero'].'-'.$row['complemento'].'-'.$row['nomecidade'].'-'.$row['sigla'].' </option>';
          else echo '<option value="'.$row['enderecoid'].'">'.$row['rua'].'-'.$row['bairro'].'-'.$row['numero'].'-'.$row['complemento'].'-'.$row['nomecidade'].'-'.$row['sigla'].'</option>';
       }
          ?>
            </select>
    	</div>
    <br>
    <br>
    
    <div class="col-sm-10">
        <label form="inputNome">Vendedor</label>      
          <select class="form-control"  name="uservendedorid">
                 
          <?php 

       $result2 = "select iduser, nome from usuario where iduser=$iduserv";
       $resultado2 = mysqli_query($bd, $result2);

       while($row = mysqli_fetch_array($resultado2)) {
          if($row['iduser'] == $uservendedorid) echo '<option selected value="'.$row['iduser'].'"> '.$row['nome'].' </option>';
          else echo '<option value="'.$row['iduser'].'"> '.$row['nome'].' </option>';
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
  
  <?php

  if (isset($sqlinsert) == true) {
    echo '<div class="alert alert-success" role="alert">
            Pedido cadastrado com sucesso!
          <a class="nav-link active" href="inserirprodutos.php">Clique aqui para adicionar produtos ao pedido</a>
          </div>';
           }
  ?>

</div>
</body>
</html>