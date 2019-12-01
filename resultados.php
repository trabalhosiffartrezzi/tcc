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

<?php  


$vendapid=$_POST["vendapid"];

$sql_ultimo_pedido = "select idvendap from venda_pedido where idvendap= $vendapid";

$valor = mysqli_query($bd, $sql_ultimo_pedido);

$retorno = mysqli_fetch_array($valor);


$sql_listar = "select produto.idprod, produto.nomeprod, produto.valor, venda_produto.idvp, venda_produto.qtde_unidade, venda_produto.total_un, venda_pedido.uservendedorid
  from 
    produto, venda_produto , venda_pedido
  where 
    produto.idprod = venda_produto.prodid and
    venda_pedido.idvendap = venda_produto.vendapid and 
    venda_pedido.idvendap =".$retorno["idvendap"]." ;";
   
   $lista = mysqli_query($bd, $sql_listar);
   
   if ( mysqli_num_rows($lista) > 0 ) {
    
    $sql_pedido = "select venda_pedido.userclienteid, venda_pedido.idvendap, venda_pedido.userclienteid, usuario.iduser, usuario.nome, usuario.cpf_cnpj, endereco.idenderec, endereco.rua, endereco.numero, endereco.bairro, endereco.cidadeid, cidade.idcidade, cidade.nomecidade
        from 
            venda_pedido, usuario, endereco, cidade
        where 
            usuario.iduser=venda_pedido.userclienteid and 
            usuario.enderecoid = endereco.idenderec and
            cidade.idcidade = endereco.cidadeid and
            venda_pedido.idvendap = $vendapid order by idvendap desc limit 1;";

        $idpedido = mysqli_query($bd, $sql_pedido);

        $resultado = mysqli_fetch_array($idpedido);


        
    $tabela = "<table class='table table-striped'>";

    $tabela = $tabela."<tr><th colspan='6'>Cliente: ".$resultado["nome"]."</th>";

    $tabela = $tabela."<tr><th colspan='6'>Endereço: Rua ".$resultado["rua"].", numero ".$resultado["numero"].", bairro ".$resultado["bairro"]." - Cidade: ".$resultado["nomecidade"]."</th>";

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

    $vendapid2 = $_POST["vendapid"];

    $sql_chave="select idvendap from venda_pedido where idvendap= $vendapid2";

    $consulta_chave = mysqli_query($bd, $sql_chave);

    $chave = mysqli_fetch_array($consulta_chave);
  
    $sqltotalpe = "select sum(total_un) from venda_produto where vendapid =".$chave["idvendap"].";";

    $total = mysqli_query($bd, $sqltotalpe);

    $totalpe = mysqli_fetch_array($total);

    $armazena2 =$totalpe[0]; 

    $tabela = $tabela."<tr><td>Total do Pedido</td><td colspan='6' >$armazena2</td></tr>";

    $tabela = $tabela."</table>"; 
   } else 
      $tabela = "não há dados para listar";
      
 ?>

<div class="container w-70">
  <legend>Pedido Selecionado</legend>
  
     <?php echo $tabela; ?>
  
  </fieldset>
  
</div>

</body>


</html>