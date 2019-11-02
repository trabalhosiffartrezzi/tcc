<!DOCTYPE html>
<html>
<head>


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


  $termobusca ="";

  $sql_pesquisa = "";

  
?>
<div class="container w-70">
     <ul class="nav justify-content-center">
     		<a class="nav-link" href="painelvendedor.php"><i class="fas fa-backward">Voltar</i></a>
  			<a class="nav-link disabled"><i class="fas fa-user">Nome Usuário</i></a>
  			<a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
  		</ul>
</div>
<div class="container w-70">
<form action="meuspedidos.php" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Insira o que você quer buscar</label>
    <input type="email" class="form-control" placeholder="Ex: Alvejante, Pedido n 16, 315 reais" name="termobusca">
  </div>
  <button type="submit" class="btn btn-primary mb-2">Enviar</button>
</form>
</div>
</body>


</html>