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

  $termobusca =$_POST["termobusca"];


 $sql_listar = "select venda_pedido.idvendap,venda_pedido.vtotal, venda_pedido.userclienteid, venda_pedido.uservendedorid, venda_pedido.observacoes, venda_pedido.enderecoid, venda_produto.vendapid, venda_produto.idvp, venda_produto.prodid, venda_produto.qtde_unidade, venda_produto.total_un, produto.idprod, produto.nomeprod, endereco.idenderec, endereco.rua, endereco.bairro, endereco.numero, endereco.cidadeid, cidade.idcidade, cidade.nomecidade, cidade.estadoid, estado.idestado, estado.sigla, usuario.iduser, usuario.nome, usuario.cpf_cnpj, usuario.telefone

    from venda_produto,venda_pedido,usuario,cidade,estado,endereco,produto

    where 
    venda_pedido.idvendap = venda_produto.vendapid and 
    produto.idprod = venda_produto.prodid and 
    usuario.iduser = venda_pedido.userclienteid and 
    endereco.idenderec = venda_pedido.enderecoid and 
    cidade.idcidade = endereco.cidadeid and 
    estado.idestado = cidade.estadoid and 
    venda_pedido.uservendedorid = $iduserv  AND
    produto.nomeprod LIKE '%$termobusca%' or  
    usuario.nome like '%$termobusca%' or 
    endereco.rua like '%$termobusca%' or endereco.bairro like '%$termobusca%' or 
    cidade.nomecidade like '%$termobusca%' or estado.sigla like '%$termobusca%' 
    order by venda_pedido.idvendap desc limit 1 ";
   
   $lista = mysqli_query($bd, $sql_listar);

   
   
   
   if ( mysqli_num_rows($lista) > 0 ) {
    
    $tabela = "<table class='table table-striped'>";
    
    $tabela = $tabela."<tr><th>Código Pedido</th><th>Nome Cliente</th><th>Cidade</th><th>Valor Total do Pedido</th>";
     
    while ( $dados = mysqli_fetch_assoc($lista) ) {
       
       $vidvendap    = $dados["idvendap"];
       $vnome  = $dados["nome"];
       $vnomecidade  = $dados["nomecidade"];
       $vvtotal = $dados["vtotal"];

       $tabela = $tabela."<tr><td>$vidvendap</td><td>$vnome</td><td>$vnomecidade</td><td>$vvtotal</td>";
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
     		<a class="nav-link" href="meuspedidos.php"><i class="fas fa-backward">Voltar</i></a>
  			<a class="nav-link disabled"><i class="fas fa-user"><?php echo $dados["nome"]?></i></a>
  			<a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
  		</ul>
</div>

</div>

<div class="container w-70">
  <legend>Resultado da pesquisa</legend>
  
     <?php echo $tabela; ?>
  
  </fieldset>
  
</div>

</body>


</html>