<!DOCTYPE html>
<html>
<head>
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



  $sql_listar = "select usuario.iduser, usuario.nome, usuario.enderecoid, venda_pedido.idvendap, venda_pedido.uservendedorid, venda_pedido.userclienteid, venda_pedido.vtotal, endereco.idenderec, endereco.rua, endereco.numero, endereco.cidadeid, cidade.idcidade, cidade.nomecidade
	from 
	usuario, venda_pedido, endereco, cidade
	where 
	usuario.iduser = venda_pedido.userclienteid and
    endereco.idenderec = usuario.enderecoid and
    cidade.idcidade = endereco.cidadeid and
	venda_pedido.uservendedorid = $iduserv limit 1";
	 
   $lista = mysqli_query($bd, $sql_listar);
	 
   if ( mysqli_num_rows($lista) > 0 ) {
		
		$tabela = "<table class='table table-striped'>";
		
		$tabela = $tabela."<tr><th  scope='col'>Código da venda</th><th scope='col'>Nome do Cliente</th><th scope='col'>Valor total do Pedido</th><th scope='col'>Rua(local de entrega)</th><th scope='col'>Numero para Entrega</th><th scope='col'>Cidade</th>
		             <th></th></tr>";
		 
		while ( $dados = mysqli_fetch_assoc($lista) ) {
		   
		   $vidvendap     = $dados["idvendap"];
		   $vuserclienteid  = $dados["userclienteid"];
		   $vvtotal  = $dados["vtotal"];
		   $vnome = $dados["nome"];
		   $vrua  = $dados["rua"];
		   $vnumero  = $dados["numero"];
		   $vnomecidade     = $dados["nomecidade"];
	   
		   $detalhar = "<form action='detalhe.php' method='post'>
		                  <input type='hidden' name='idvendap' value='$vidvendap'>
		                  <input type='submit' class='btn btn-secondary' value='Ver pedido detalhado'> 
		               </form>";
		   
		   $tabela = $tabela."<tr><td scope='col'>$vidvendap</td><td scope='col'>$vnome</td><td scope='col'>$vvtotal</td><td scope='col'>$vrua</td><td scope='col'>$vnumero</td><td scope='col'>$vnomecidade</td>
		        <td scope='col'>$detalhar</td></tr>";
		}
		
		$tabela = $tabela."</table>"; 
   } else 
	    $tabela = "não há dados para listar";
	   
?>
<div class="container w-70">
     <ul class="nav justify-content-end">
  			<a class="nav-link disabled"><i class="fas fa-user">Nome Usuário</i></a>
  			<a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
  		</ul>
</div>
<div class="container col-md-6">
<fieldset>
<legend>Meus pedidos/vendas</legend>
  
     <?php echo $tabela; ?>
  
</fieldset>
</div>
</body>

<div class="container w-70">
<a href="painelvendedor.php"><i class="fas fa-backward fa-lg">Voltar</i></a>
</div>
</html>