<!DOCTYPE html>
<html>
<head>
	<title>Insira os produtos no pedido</title>

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
  $idvp     = "";
	$observacoes  = "";
	$qtde_unidade  = "";
	$prodid  = "";
	$vendapid  = "";

   	########### Acao de inserir
   	if ( ! isset($_POST["acao"]) )
     		$descr_acao = "Incluir";
  	else {
	 
	$acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $idvp     = mysqli_real_escape_string($bd, $_POST["idvp"] );
	    $qtde_unidade  = mysqli_real_escape_string($bd, $_POST["qtde_unidade"] );
	    $prodid  = mysqli_real_escape_string($bd, $_POST["prodid"] );
     }

     if (strtoupper($acao) == "INCLUIR") {

     	if($vendapid == false ){

     	$sql_consulta = "select idvendap, uservendedorid from venda_pedido where uservendedorid = '$iduserv' order by idvendap desc limit 1;";

			$chave = mysqli_query($bd,$sql_consulta);

			$retorno = mysqli_fetch_array($chave);

			$sqlinsert = "insert into venda_produto (qtde_unidade, prodid, vendapid) values ($qtde_unidade, $prodid,".$retorno["idvendap"].");";

      $insert = mysqli_query($bd, $sqlinsert);

      if ($insert == true) {
            
            $sql_qtde = "select qtde_unidade from venda_produto order by idvp desc limit 1";
            $sql_valorun = "select produto.valor from produto, venda_produto where produto.idprod = venda_produto.prodid order by venda_produto.idvp desc limit 1";
       
            $valor1 = mysqli_query($bd,$sql_qtde);
            $valor2 = mysqli_query($bd,$sql_valorun);
      
            $retorno1 = mysqli_fetch_array($valor1);
            $retorno2 = mysqli_fetch_array($valor2);
      
            $qtde_unidade = $retorno1["qtde_unidade"];
            $valor = $retorno2["valor"];

            $total_un = $qtde_unidade * $valor;

            $sql_total_un = "update venda_produto set total_un = $total_un order by idvp desc limit 1";
            
            $gravar = mysqli_query($bd,$sql_total_un);
    
            }
                    
	if ( ! $insert ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";

		 	} else {
		     $descr_acao = "Salvar";

		     $idvp = mysqli_insert_id($bd);
		 	  } 
     	}
	 }

   if (strtoupper($acao) == "EXCLUIR") {
        
      $idvp = $_POST["idvp"];

      $descr_acao = "Incluir";

      $delete = " delete from venda_produto WHERE venda_produto.idvp = $idvp";

      $sql = mysqli_query($bd,$delete);

      if ( !$sql ) {

        if (mysqli_errno($bd) == 1451) {

          $mensagem = "Não é possível excluir uma produto enquanto houver pedido cadastrado a ele!";
        }
    }

      $idvp = "";
      $prodid = "";
     }

}

$sql_ultimo_pedido = "select idvendap from venda_pedido where uservendedorid = $iduserv order by idvendap desc limit 1";

$valor = mysqli_query($bd, $sql_ultimo_pedido);

$retorno = mysqli_fetch_array($valor);


$sql_listar = "select produto.idprod, produto.nomeprod, produto.valor, venda_produto.idvp, venda_produto.qtde_unidade, venda_produto.total_un, venda_pedido.uservendedorid
  from 
    produto, venda_produto , venda_pedido
  where
    venda_pedido.uservendedorid = $iduserv and 
    produto.idprod = venda_produto.prodid and
    venda_pedido.idvendap = venda_produto.vendapid 
   order by
    venda_produto.idvp =".$retorno["idvendap"]." ;";
   
   $lista = mysqli_query($bd, $sql_listar);
   
   if ( mysqli_num_rows($lista) > 0 ) {
    
    $tabela = "<table border='1'>";
    
    $tabela = $tabela."<tr><th>Codigo Produto</th><th>Quantidade</th><th>Nome</th><th>Valor Unitario</th><th>Total</th>
    <th>Excluir</th></tr>";
     
    while ( $dados = mysqli_fetch_assoc($lista) ) {
       
       $vidvp = $dados["idvp"];
       $vidpro = $dados["idprod"];
       $vnomeprod = $dados["nomeprod"];
       $vvalor = $dados["valor"];
       $vqtde_unidade = $dados["qtde_unidade"];
       $vtotal_un = $dados["total_un"];
       $vuservendedorid = $dados["uservendedorid"];

       $excluir = "<form method='post'>
                      <input type='hidden' name='idvp' value='$vidvp'>
                      <input type='hidden' name='acao' value='EXCLUIR'>
                      <input type='image' src='./img/deletar.png'>
                      
                   </form>";

       $tabela = $tabela."<tr><td>$vidpro</td><td>$vqtde_unidade</td><td>$vnomeprod</td><td>$vvalor</td><td>$vtotal_un</td>
       <td>$excluir</td></tr>";

    }   

    $sql_chave="select idvendap from venda_pedido where uservendedorid = $iduserv  order by idvendap desc limit 1";

    $consulta_chave = mysqli_query($bd, $sql_chave);

    $chave = mysqli_fetch_array($consulta_chave);

    $armazena1 =$chave[0];

    $sqltotalpe = "select sum(total_un) from venda_produto where vendapid =".$armazena1.";";

    $total = mysqli_query($bd, $sqltotalpe);

    $totalpe = mysqli_fetch_array($total);

    $armazena2 =$totalpe[0]; 

    $tabela = $tabela."<tr><td>Total do Pedido</td><td colspan='5' >$armazena2</td></tr>";

    $tabela = $tabela."</table>"; 
   } else 
      $tabela = "não há dados para listar";
      
 ?>

  <div class="container w-70">
      <<ul class="nav justify-content-end">
        <a class="nav-link disabled"><i class="fas fa-user">Nome Usuário</i></a>
        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt">Sair</i></a> 
      </ul>
  </div>
 <div class="container w-70">

  <?php

    $sql_pedido = "select venda_pedido.uservendedorid, venda_pedido.idvendap, venda_pedido.userclienteid, usuario.iduser, usuario.nome, usuario.cpf_cnpj
        from 
            venda_pedido, usuario
        where 
            venda_pedido.uservendedorid = $iduserv and usuario.cpf_cnpj = '$cpf_cnpjv' order by idvendap desc limit 1;";

    $lista1 = mysqli_query($bd, $sql_pedido);
        
    if ( mysqli_num_rows($lista1) > 0 ) {
    
    $tabela1 = "<table>";
    
    $tabela1= $tabela1."<tr><th>Codigo da Venda</th><th>Vendedor</th></tr>";
     
    while ( $dados = mysqli_fetch_assoc($lista1) ) {
       
       $pidvendap = $dados["idvendap"];
       $pnome = $dados["nome"];
       
       $tabela1 = $tabela1."<tr><td>$pidvendap</td><td>$pnome</td></tr>";
    } 
      $tabela1 = $tabela1."</table>"; 
    } else 
      $tabela1 = "não há dados para listar";            
  ?>
    <div class="alert alert-warning" role="alert">
      <?php echo $tabela1; ?>
    </div>
 <form action="inserirprodutos.php" method="post">
  <div class="form-group ">
    <h2>Insira os produtos abaixo</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idvp" value="<?php echo $idvp;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Quantidade</label> 
      <input type="text" class="form-control" name="qtde_unidade" value="<?php echo $qtde_unidade;?>" placeholder="Quantidade">
    </div>
    <br>
    <br>
        <div class="col-sm-10">
        <label form="inputNome">Produto</label>      
          <select class="form-control"  name="prodid">     
          <?php 

       $result = "select idprod, nomeprod, valor from produto";
       $resultado = mysqli_query($bd, $result);

       while($row = mysqli_fetch_assoc($resultado)) {
          if($row['idprod'] == $prodid) echo '<option selected value="'.$row['idprod'].'"> '.$row['nomeprod'].'--- Valor(R$):'.$row['valor'].' </option>';
          else echo '<option value="'.$row['idprod'].'"> '.$row['nomeprod'].'--- Valor(R$):'.$row['valor'].' </option>'; 
       }
          ?>
            </select>
    	</div>
    <br>
    <br>
   	<div class="form-group row">
    <div class="col-sm-10">
      <input type="submit" class="btn btn-primary" value="Novo Produto">
      <input type="submit" class="btn btn-secondary" name="acao" value="<?php echo $descr_acao; ?>">
    </div>
  	</div>
  </div>  
</form>

<fieldset>
<legend>Produtos Inseridos</legend>
  
     <?php echo $tabela; ?>
  
</fieldset>
<br>
<br>
<div class="alert alert-danger" role="alert">
  <a href="observacoes.php">Clique aqui para concluir o pedido</a>
</div>
<div class="container w-70">
<a href="novopedido.php"><i class="fas fa-backward fa-lg">Voltar</i></a>
</div>
</body>
</html>