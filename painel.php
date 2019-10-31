

<!DOCTYPE html>
<html>
<head>
	<title>Painel Administrativo</title>
	<?php

session_start();

if (isset($_SESSION["cpf_cnpj"]) && isset($_SESSION["iduser"] )) {
    $cpf_cnpjv = $_SESSION["cpf_cnpj"];
    $iduserv = $_SESSION["iduser"];
  } else{
    header('location:index.php?Erro ao acessar os dados');
  }
 
  ?>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>
<ul class="nav">
  <li class="nav-item">
    <a class="nav-link active" href="cadastracategoria.php">Gerenciar Categorias</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="cadastraproduto.php">Gerenciar Produtos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="cadastracidades.php">Gerenciar Cidades</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="cadastrausuario.php">Gerenciar Usuarios</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Gerenciar Pagamentos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="novopedido.php">Faça seu Pedido Aqui!</a>
  </li>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="meuspedidos.php">Ver meus pedidos</a>
  </li>
</ul>
</body>
</html>