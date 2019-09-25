<?php
     
   session_start();
   $bd = mysqli_connect("localhost","root","","tcc");

   if($bd){ 
         mysqli_set_charset($bd, "utf8");
   }else{
         echo "Não foi possível conectar o BD <br>";
         echo "Mensagem de erro: ".mysqli_connect_error() ;
   exit();
      }
   
   if ( isset($_POST["cpf_cnpj"]) )
      $cpf_cnpj = $_POST["cpf_cnpj"];
   else
      $cpf_cnpj = "";
   
   if ( isset ($_POST["senha"]) )
      $senha = md5($_POST["senha"]);
   else
      $senha = "";
   
   $sql = "select * from usuario where cpf_cnpj = '$cpf_cnpj' and senha = '$senha' ";
     
   $resultado = mysqli_query($bd,$sql);

   if ( mysqli_num_rows($resultado) > 0 ) {

      $dados = mysqli_fetch_assoc($resultado);
      
      $_SESSION['cpf_cnpj'] = $cpf_cnpj;
      header('location: painel.php');
   
   }else{

      header('location:index.php?Erro ao acessar os dados');
   
  }
?>

   
    



















