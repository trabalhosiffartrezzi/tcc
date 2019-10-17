<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Login do Sistema</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script src="https://kit.fontawesome.com/5227edd223.js"></script>

  <script type="text/javascript" src="mascara/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="mascara/jquery.mask.min.js"></script>

  <script type="text/javascript">
 
  $(document).ready(function(){
    
   $(document).on('keydown', '[data-mask-for-cpf-cnpj]', function (e) {

    var digit = e.key.replace(/\D/g, '');

    var value = $(this).val().replace(/\D/g, '');

    var size = value.concat(digit).length;

    $(this).mask((size <= 11) ? '000.000.000-00' : '00.000.000/0000-00');

  });

 });

</script>

</head>
<body>
	<div class="container col-6 justify-content-center" >
  	<form action="login.php" method="post">
  		<div class="form-group">
    <label for="exampleInputEmail1">CPF ou CNPJ</label>
    <input type="text" data-mask-for-cpf-cnpj class="form-control" id="cpf_cnpj" name="cpf_cnpj" placeholder="Insira seu CFP ou CNPJ(apenas numeros)">
  		</div>
  		<div class="form-group">
    <label for="exampleInputPassword1">Senha</label>
    <input type="password" class="form-control" id="senha" name="senha" placeholder="Insira sua senha">
  		</div>
  <button type="submit" class="btn btn-primary" value="login">Entrar</button>
</form>

	</div>
</body>
</html>