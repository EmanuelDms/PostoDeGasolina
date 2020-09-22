<?php
session_start();
require("../funcoesBanco.php");
$link = conecta();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Login Gerente</title>
	<link rel="stylesheet" type="text/css" href="../page.css">
	<script type="text/javascript">
		function mostrarSenha(){
			check = document.getElementById("mostrar");
				if (check.checked) {
					document.getElementById("senhaGerente").type='text';
				}else{
					document.getElementById("senhaGerente").type='password';	
				}
			}
	</script>
</head>
<body>
	<form method="post" action="index.php" name="formulario">
		<p><label>MATRICULA</label></p>
			<input type="text" name="idGerente" placeholder="Coloque sua matrícula..."/>
		<p><label>SENHA</label></p>
			<input type="password" name="senhaGerente" id='senhaGerente' placeholder="Insira sua senha..."/>

		<p><input type="checkbox" id="mostrar" onclick="mostrarSenha()"/>
			<font id='textoP'> Mostrar senha</font></p>
		<p><input type="submit" name="ok" value="Logar"></p>
	</form>
	<?php
	if (@$_POST["ok"]) {
		$idGerente = @$_POST["idGerente"];
		$senhaGerente = @$_POST["senhaGerente"];
		$sql = "SELECT * FROM gerente;";
		$query = mysqli_query($link,$sql) or die("Erro na query: ".mysqli_error($link));
		if (($idGerente == '' && $senhaGerente == '') || ($idGerente == '' || $senhaGerente == '')) {
			echo "Preencha os dados";
		}else{
			while ($row = mysqli_fetch_assoc($query)) {
				if ($row["idgerente"] == $idGerente) {
					$user = true;
					if ($row["senha_gerente"] == $senhaGerente) {
						$pass = true;
						$_SESSION["gerenteLogado"] = $row["nome_gerente"];
						$_SESSION["idGerente"] = $row["idgerente"];
						echo"<script language='javascript' type='text/javascript'>alert('Seja bem-vindo, ".$_SESSION["gerenteLogado"]."');window.location.href='../2MenuPrincipal/index.php'</script>";
						
					}else{ $pass = false; }
				}else{ $user = false; }
			}
			
			if (!($user)) {
				$pass = false;
			}
			if (!($user && $pass)) {
				echo "<script language='javascript' type='text/javascript'>alert('Dados informados inválidos!');</script>";
			}
		}
	}
	?>
</body>
</html>
<?php require("../Imagens/copyright.php"); mysqli_close($link); ?>