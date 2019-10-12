<!DOCTYPE html>
<html>
<head>
	<title>Gerenciar Usuários</title>
	
	<?php 
		include_once("painel.php")
 
	?>

  <script type="text/javascript" src="mascara/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="mascara/jquery.mask.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function(){
    $("#cpf_cnpj").mask('00.000.000/0000-00');
  })
  </script>

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

  $iduser    = "";
  $nome = "";
  $funcao = "";
  $telefone = "";
  $senha = "";
  $cpf_cnpj = "";
  $email = "";
  $enderecoid = "";
  $idenderec = "";
  $rua = "";
  $bairro = "";
  $numero = "";
  $complemento = "";
  $cidadeid = "";
  
  if ( ! isset($_POST["acao"]) )
     $descr_acao = "Incluir";
  else {
	 
	 $acao = $_POST["acao"];
	 
	 if (strtoupper($acao) == "INCLUIR" || strtoupper($acao) == "SALVAR" ) {
	    $iduser     = mysqli_real_escape_string($bd, $_POST["iduser"] ) ;
	    $nome  = mysqli_real_escape_string($bd, $_POST["nome"] ) ;
	    $funcao  = mysqli_real_escape_string($bd, $_POST["funcao"] ) ;
	    $telefone  = mysqli_real_escape_string($bd, $_POST["telefone"] ) ;
	    $senha  = mysqli_real_escape_string($bd, $_POST["senha"] ) ;
	    $cpf_cnpj  = mysqli_real_escape_string($bd, $_POST["cpf_cnpj"] ) ;
      $email  = mysqli_real_escape_string($bd, $_POST["email"] ) ;
      $idenderec  = mysqli_real_escape_string($bd, $_POST["idenderec"] ) ;
      $rua  = mysqli_real_escape_string($bd, $_POST["rua"] ) ;
      $bairro  = mysqli_real_escape_string($bd, $_POST["bairro"] ) ;
      $numero  = mysqli_real_escape_string($bd, $_POST["numero"] ) ;
      $complemento  = mysqli_real_escape_string($bd, $_POST["complemento"] ) ;
      
      $cidadeid  = mysqli_real_escape_string($bd, $_POST["cidadeid"] ) ;
     }

     if (strtoupper($acao) == "INCLUIR") {
      
      ##Checa se o campo e nulo
      if ($idenderec == false){

        $sql = "insert into endereco (rua,bairro,numero,complemento,cidadeid) values ('$rua','$bairro',$numero,'$complemento',$cidadeid);";
        ##insere os dados na tabela endereco
       $result1 = mysqli_query($bd, $sql);

        ##recupera a ultima chave da tabela endereco
        $chave_estrangeira =  " select idenderec from endereco order by idenderec desc limit 1";
        
        $chave = mysqli_query($bd,$chave_estrangeira);
        $chave = mysqli_fetch_array($chave);
      
         ##insere a chave recuperada na tabela usuario
        $sql2 = "insert into usuario(nome, funcao, telefone, senha, cpf_cnpj, email, enderecoid) values ( '$nome', '$funcao','$telefone', md5('$senha'), '$cpf_cnpj', '$email', ".$chave['idenderec'].");";

        $result2 = mysqli_query($bd, $sql2 );
      
      }
		                
		 if ( !$result1 && !$result2  ) {

			    $mensagem = "<h3>Ocorreu um erro ao inserir os dados </h3>
			              <h3>Erro: ".mysqli_error($bd)."</h3>
			              <h3>Código: ".mysqli_errno($bd)."</h3>";
		   	 
		   	    $descr_acao = "Incluir";

		 } else {
		     $descr_acao = "Salvar";

		     $iduser = mysqli_insert_id($bd);
		 }
	 }
	 
	 if (strtoupper($acao) == "SALVAR") {
		 
		 $descr_acao = "Salvar";
		 
		 $sql = " update 
		              endereco, cidade
		          set 
		              endereco.rua = '$rua',
                  endereco.bairro = '$bairro',
                  endereco.numero = $numero,
                  endereco.complemento = '$complemento',
                  endereco.cidadeid = $cidadeid
		          where 
                  cidade.idcidade = endereco.cidadeid and
		              endereco.idenderec = $idenderec ";

      $sql2 = " update
                  usuario
                set
                  nome = '$nome',
                  funcao = '$funcao',
                  telefone = '$telefone',
                  senha = '$senha',
                  cpf_cnpj = '$cpf_cnpj',
                  email = '$email',
                  enderecoid = $idenderec
                where
                  iduser = $iduser ";

                  
		 if ( ! mysqli_query($bd, $sql2) &&  ! mysqli_query($bd, $sql) ) {
			 
			 $mensagem = "<h3>Ocorreu um erro ao alterar os dados </h3>
			 <h3>".mysqli_error($bd)."</h3>".$sql."<h4>".mysqli_errno($bd)."</h4>";
			 
		 }
	 }

     if (strtoupper($acao) == "EXCLUIR") {
        
      $iduser = $_POST["iduser"];

     	$descr_acao = "Incluir";

      $delete = " select * from usuario where iduser = $iduser";

      $resultado = mysqli_query($bd, $delete);

      $resultado = mysqli_fetch_array($resultado);

     	$sql2 = "delete from endereco where idenderec = ".$resultado['enderecoid'];
      $sql = "delete from usuario where iduser = $iduser ";
      
      $result3 = mysqli_query($bd, $sql);
      $result4 = mysqli_query($bd, $sql2);
      
     	if ( !$result3  && !$result4  ) {

     		if (mysqli_errno($bd) == 1451) {

     			$mensagem = "Não é possível excluir uma usuario enquanto houverem endereços cadastrados a ele!";
     		}
		}

     	$idenderec = "";
      $iduser = "";
     }

     if (strtoupper($acao) == "BUSCAR") {

      $iduser = $_POST["iduser"];
      

     	$descr_acao = "Salvar";

      $sql = "select iduser, nome, funcao, telefone, senha, cpf_cnpj, email, enderecoid 
              from usuario
              where iduser = '$iduser' ";
             
      $resultado2 = mysqli_query($bd, $sql);
      $user = mysqli_fetch_array($resultado2);

     	$sql2 = "select idenderec, rua, bairro, numero, complemento, cidadeid 
     	        from endereco
     	        where idenderec = ".$user['enderecoid'];  
              

     	$resultado = mysqli_query($bd, $sql2);

     	if (mysqli_num_rows($resultado) == 1 && mysqli_num_rows($resultado2) == 1) {

             $dados = mysqli_fetch_assoc($resultado);

             $idenderec    = $dados["idenderec"];
             $rua = $dados["rua"];
             $bairro = $dados["bairro"];
             $numero = $dados["numero"];
             $complemento = $dados["complemento"];
             $cidadeid = $dados["cidadeid"];
             $iduser = $user["iduser"];
             $nome = $user["nome"];
             $telefone = $user["telefone"];
             $funcao = $user["funcao"];
             $senha = $user["senha"];
             $cpf_cnpj = $user["cpf_cnpj"];
             $email = $user["email"];
             $enderecoid = $user["enderecoid"];

     	}
     }
   }
	 
   $sql_listar = "select endereco.idenderec, endereco.rua, endereco.bairro, endereco.numero, endereco.complemento, endereco.cidadeid, usuario.iduser, usuario.nome, usuario.funcao, usuario.telefone, usuario.senha, usuario.cpf_cnpj, usuario.email,usuario.enderecoid, cidade.nomecidade
   			from 
   				endereco, usuario, cidade
   			where
   				endereco.idenderec = usuario.enderecoid and
          endereco.cidadeid = cidade.idcidade
   			order by usuario.nome";
	 
   $lista = mysqli_query($bd, $sql_listar);
	 
   if ( mysqli_num_rows($lista) > 0 ) {
		
		$tabela = "<table border='1'>";
		
		$tabela = $tabela."<tr><th>Código</th><th>Nome</th><th>Funcao</th><th>Telefone</th><th>Senha</th><th>CPF ou CNPJ</th><th>Email</th><th>Rua</th><th>Bairro</th><th>Numero</th><th>complemento</th><th>Cidade</th>
		             <th>Alterar</th><th>Excluir</th></tr>";
		 
		while ( $dados = mysqli_fetch_assoc($lista) ) {
		   
		   $videnderec     = $dados["idenderec"];
		   $vrua  = $dados["rua"];
		   $vbairro  = $dados["bairro"];
		   $vnumero = $dados["numero"];
		   $vcomplemento  = $dados["complemento"];
		   $vcidadeid  = $dados["cidadeid"];
		   $vnomecidade     = $dados["nomecidade"];
		   $vidsuer     = $dados["iduser"];
       $vnome     = $dados["nome"];
       $vfuncao     = $dados["funcao"];
       $vtelefone     = $dados["telefone"];
       $vsenha     = $dados["senha"];
       $vcpf_cnpj     = $dados["cpf_cnpj"];
       $vemail     = $dados["email"];


		   $alterar = "<form method='post'>
		                  <input type='hidden' name='iduser' value='$vidsuer'>
		                  <input type='hidden' name='acao' value='BUSCAR'>
		                  <input type='image' src='./img/editar.png'> 
		               </form>";
		   
		   $excluir = "<form method='post'>
		                  <input type='hidden' name='iduser' value='$vidsuer'>
		                  <input type='hidden' name='acao' value='EXCLUIR'>
		                  <input type='image' src='./img/deletar.png'>
		                  
		               </form>";
		   
		   $tabela = $tabela."<tr><td>$vidsuer</td><td>$vnome</td><td>$vfuncao</td><td>$vtelefone</td><td>$vsenha</td><td>$vcpf_cnpj</td><td>$vemail</td><td>$vrua</td><td>$vbairro</td><td>$vnumero</td><td>$vcomplemento</td><td>$vnomecidade</td>
		        <td>$alterar</td><td>$excluir</td></tr>";
		}
		
		$tabela = $tabela."</table>"; 
   } else 
	    $tabela = "não há dados para listar";
	    

    ?>
 <div class="container col-md-6">
 <form action="cadastrausuario.php" method="post">
  <div class="form-group ">
    <h2>Cadastro de Usuários</h2>
     <div class="col-sm-10">
      <input type="hidden" class="form-control" name="iduser" value="<?php echo $iduser;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Nome</label> 
      <input type="text" class="form-control" name="nome" value="<?php echo $nome;?>" placeholder="Nome">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Função</label> 
      <input type="text" class="form-control" name="funcao" value="<?php echo $funcao;?>" placeholder="Função">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Telefone</label> 
      <input type="text" class="form-control" name="telefone" value="<?php echo $telefone;?>" placeholder="Telefone (com DDD)">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Senha</label> 
      <input type="password" class="form-control" name="senha" value="<?php echo $senha;?>" placeholder="Senha">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">CPF ou CNPJ</label> 
      <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="<?php echo $cpf_cnpj;?>" placeholder="CPF ou CNPJ">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Email</label> 
      <input type="text" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Email">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <input type="hidden" class="form-control" name="idenderec" value="<?php echo $idenderec;?>">
    </div>
    <div class="col-sm-10">
      <label form="inputNome">Rua</label> 
      <input type="text" class="form-control" name="rua" value="<?php echo $rua;?>" placeholder="Rua">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Bairro</label> 
      <input type="text" class="form-control" name="bairro" value="<?php echo $bairro;?>" placeholder="Bairro">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Numero</label> 
      <input type="text" class="form-control" name="numero" value="<?php echo $numero;?>" placeholder="Numero">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
      <label form="inputNome">Complemento</label> 
      <input type="text" class="form-control" name="complemento" value="<?php echo $complemento;?>" placeholder="complemento">
    </div>
    <br>
    <br>
    <div class="col-sm-10">
        <label form="inputNome">Cidade</label>      
          <select class="form-control"  name="cidadeid">
                 
          <?php 

       $result = "select idcidade, nomecidade from cidade";
       $resultado = mysqli_query($bd, $result);

       while($row = mysqli_fetch_assoc($resultado)) {
          if($row['idcidade'] == $cidadeid) echo '<option selected value="'.$row['idcidade'].'"> '.$row['nomecidade'].' </option>';
          else echo '<option value="'.$row['idcidade'].'"> '.$row['nomecidade'].' </option>';
         
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
<legend>Usuários Cadastrados</legend>
	
	   <?php echo $tabela; ?>
	
</fieldset>

</div>

</body>
</html>
<?php
  
  mysqli_close($bd);

?>