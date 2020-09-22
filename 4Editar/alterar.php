<?php  
session_start();
require("../funcoesBanco.php");
$conexao = conecta();
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		body{
		    margin: 0;
		    padding: 0;
		    font-family: sans-serif;
		    background-size: cover; 
		    background-color: #ffd280;
		}form{
			margin: 10px;
			padding: 10px;
			background-color: #ff9900;
			text-align: center;
		}h1{
		    float: center;
		    font-size: 40px;
		    border-bottom: 6px solid #ffa200;
		    margin-bottom: 50px;
		    padding: 13px 0;
			text-align: center;
			color: black;
			background-color: white;
		}input{
			border: none;
		    outline: none;
		    background: none;
		    color: black;
		    font-size: 18px;
		    width: 80%;
		    float: center;
		    margin: 0 10px;
		}select{
		    border: 100%;
		    outline: none;
		    background: white;
		    font-size: 18px;
		    width: 80%;
		    float: center;
		    margin: 0 10px;
		    border-radius: 10px;
		}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset= utf-8"/>
	<title>Editar Frentista</title>
</head>
<body>
	<h1><img src="../Imagens/logoPosto.png" width="100px" height="50px" align="left">Editar Frentista</h1>
	<form method="POST" action="alterar.php">
	<?php
	$resultado = mysqli_query($conexao, "SELECT * FROM  frentista");?>
	<select name="idF">
		<option checked value="nulo">-</option>
	<?php 
	while ($linha = mysqli_fetch_assoc($resultado)) {?>
	<option value="<?php echo $linha['idfrentista'];?>">
	<?php 
		echo $linha['nome_frentista']." - ".$linha['cpf_frentista'];
		echo "</option>";
	}?>
	</select>
	<p><input type="submit" name="ok" value="Selecionar" class="botao"></p>
	</form>
	<?php
	if (@$_POST["ok"]) {
	    @$idF = $_POST['idF'];
	    $sql = "SELECT * FROM frentista WHERE idfrentista = '".$idF."';";
	     $resultado1 = mysqli_query($conexao, $sql) or die("Erro na query: ".mysqli_error($conexao));
	     ?>

	     <form method="post" action="alterar.php"> 
	     <?php
	     if ($idF == "nulo") {
	    	print "<h3>Campo vazio!</h3>";
	    }
	     while ($linha = mysqli_fetch_array($resultado1)) {?>
			<input type="hidden" name="idF" value="'<?php echo $linha["idfrentista"];?>'"/>

			<p><label> Nome: </label><input type="text" name="nome" value= '<?php echo $linha["nome_frentista"];?>' />
			</p>
			
			<p><label> Status: <?php echo $linha["status_frentista"]; ?></label> 
				<select name="status">
					<?php
					if ($linha["status_frentista"]) {
						echo "<option value='".$linha["status_frentista"]."'>Ativo</option><option value='0'>Inativo</option>";
					}else{
						echo "<option value='".$linha["status_frentista"]."'>Inativo</option><option value='1'>Ativo</option>";
					}
					?>
				</select>
			</p>
			<p>
			<input type="submit" name="editar" value="Editar" class="botao" />
			</p>	
		<?php
		}
		?>
	</form>
	<?php }
	if (@$_POST["editar"]) {
		@$id_frentista = $_POST["idF"];
		@$nome = $_POST["nome"];
		@$status_frentista = $_POST["status"];
		$update = "UPDATE frentista SET nome_frentista = '".$nome."',status_frentista = '".$status_frentista."' WHERE idfrentista = ".$id_frentista.";";
		if (mysqli_query($conexao,$update)) {
			echo"<script language='javascript' type='text/javascript'>alert('Usuário alterado com sucesso!');window.location.href='../2MenuPrincipal/'</script>";
		}else{
			die("Erro na query: ".mysqli_error($conexao));
		}
    }?> 
</body>
</html>
<?php mysqli_close($conexao); ?>
<link rel="stylesheet" type="text/css" href="../page.css">
	<?php require("../Imagens/copyright.php"); ?>
