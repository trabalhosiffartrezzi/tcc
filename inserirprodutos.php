<!DOCTYPE html>
<html>
<head>
	<title>Insira os produtos no pedido</title>

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

     	$sql_consulta = 'select idvendap from venda_pedido order by idvendap desc limit 1';

			$chave = mysqli_query($bd,$sql_consulta);
			$retorno = mysqli_fetch_array($chave);

      $vendapid = $retorno["idvendap"];

			$sqlinsert = "insert into venda_produto (qtde_unidade, prodid, vendapid) values ($qtde_unidade, $prodid,'$vendapid');";

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

      $delete = " select * from venda_produto where idvp = $idvp";

      $resultado = mysqli_query($bd, $delete);

      $resultado = mysqli_fetch_array($resultado);

      $sql = "delete from venda_produto where prodid =".$resultado["prodid"];
      $sql3 = "delete from venda_pedido where idvp = $idvp";


      $result = mysqli_query($bd, $sql);
      $result3 = mysqli_query($bd, $sql3);      
      
      if ( !$result &&  !$result3 ) {

        if (mysqli_errno($bd) == 1451) {

          $mensagem = "Não é possível excluir uma produto enquanto houver pedido cadastrado a ele!";
        }
    }

      $idvp = "";
      $prodid = "";
     }

}


$sql_listar = " select produto.idprod, produto.nomeprod, produto.valor, venda_produto.idvp, venda_produto.qtde_unidade, venda_produto.total_un 
  from 
    produto, venda_produto
  where
    produto.idprod = venda_produto.prodid
  order by 
    venda_produto.prodid";
   
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

       $excluir = "<form method='post'>
                      <input type='hidden' name='idvp' value='$vidvp'>
                      <input type='hidden' name='acao' value='EXCLUIR'>
                      <input type='image' src='./img/deletar.png'>
                      
                   </form>";

       $tabela = $tabela."<tr><td>$vidpro</td><td>$vqtde_unidade</td><td>$vnomeprod</td><td>$vvalor</td><td>$vtotal_un</td>
       <td>$excluir</td></tr>";

    }   

    $sqltotalpe = "select sum(total_un) from venda_produto;";

    $total = mysqli_query($bd, $sqltotalpe);

    $totalpe = mysqli_fetch_array($total);

    $armazenatotal = $totalpe[0];
    
    $tabela = $tabela."<tr><td>Total do Pedido</td><td colspan='5' >$armazenatotal</td></tr>";

    $tabela = $tabela."</table>"; 
   } else 
      $tabela = "não há dados para listar";
      
 ?>
 <div class="container col-md-6">
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
  <a href="#">Clique aqui para concluir o pedido</a>
</div>
</body>
</html>