<?php
session_start();
require("../funcoesBanco.php");
$link = conecta();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../page.css">
	<title>Menu Principal</title>

</head>
<body>
	<form method="post" action="." name="formulario">
		<center>
			<img src="../Imagens/logoPosto.png" width="300px" height="130px">
		</center>
		<hr class="hrMenu">
		<h1>Bem-vindo(a), <?php echo $_SESSION["gerenteLogado"];?></h1>
		<hr class="hrMenu">
		<fieldset>
				<p><label>LISTAR</label></p>
				<select name="op" class="select">
					<option checked value="0">-</option>
					<option value="1">Frentistas</option>
					<option value="2">Tanques</option>
					<option value="3">Bombas</option>
					<option value="4">Editar</option>
					<option value="5">Abastecer Veículo</option>
				</select>
		<p><input type="submit" name="ok" value="Buscar"></p>
		<p>
		<?php
		@$selecione = $_POST['op'];
		if (@$_POST["ok"]) {
			$select2 = "SELECT f.*, e.*, g.*, c.* FROM frentista as f, escala as e, gerente as g, cracha as c WHERE e.gerente_idgerente = g.idgerente AND f.escala_idescala = e.idescala AND c.frentista_idfrentista
= f.idfrentista ORDER BY nome_frentista ASC";
			$select1 = "SELECT * FROM tanque ORDER BY tipo_combustivel ASC";
			$select3 = "SELECT b.*, t.* FROM bomba as b, tanque as t WHERE b.tipocombustivel = t.idtanque ORDER BY idbomba ASC";

			$sql = mysqli_query($link,$select2) or die("Erro na requisição");
			$sql1 = mysqli_query($link,$select1) or die("Erro na requisição");
			$sql2 = mysqli_query($link, $select3) or die("Erro na requisição");


			if ($selecione == 1) {
				echo "<script language='javascript' type='text/javascript'>alert('Frentistas Carregados');</script>";
				echo "<table border='1pt' class='tabela'><caption class='tetitulo'>Frentista</caption><th>Nome</th><th>Crachá</th><th>CPF</th><th>Horário de Início</th><th>Horário de Saída</th><th>Gerente</th><th>Status</th>";
			    while($row = mysqli_fetch_assoc($sql)){
					echo "<tr><td>".$row["nome_frentista"]."</td><td>".$row["idcracha"]."</td><td>".formatCnpjCpf($row["cpf_frentista"])."</td><td>".$row["hora_inicio"]."</td><td>".$row["hora_fim"]."</td><td>".$row["nome_gerente"]."</td><td>".Status($row["status_frentista"])."</td></tr>";
			    }
				echo "</table>";
			}else if($selecione == 2){
				echo "<script language='javascript' type='text/javascript'>alert('Tanques Carregados');</script>";
				echo "<table border='1pt' class='tabela1'><caption class='tetitulo'>Tanques</caption><th>Id Tanque</th><th>Tipo Combustivel</th><th>Litragem (Litros)</th><th>Preço</th>";
			    while($row = mysqli_fetch_assoc($sql1)){
					echo "<tr><td>".$row["idtanque"]."</td><td>".$row["tipo_combustivel"]."</td><td>".$row["litragem"]."</td><td>".$row["preco_litro"]."</td></tr>";
			    }
				echo "</table>";
			}else if ($selecione == 3){
				echo "<script language='javascript' type='text/javascript'>alert('Bombas Carregadas');</script>";
				echo "<table border='1pt' class='tabela1'><caption class='tetitulo'>Bombas</caption><th>Id Bomba</th><th>Combustivel</th><th>Contagem (Litros)</th>";
			    while($row = mysqli_fetch_assoc($sql2)){
					echo "<tr><td>".$row["idbomba"]."</td><td>".$row["tipo_combustivel"]."</td><td>".$row["contagem_bomba"]."</td></tr>";
			    }
				echo "</table><br><table border='1pt' class='tabela1'><caption class='tetitulo'>Soma Bombas</caption><th>Id Bomba</th><th>Contagem (Litros)</th><th>Contagem (Litros)</th>";
				while($row = mysqli_fetch_assoc($sql2)){
					echo "<tr><td>".$row["idbomba"]."</td><td>".	mysqli_query($link, "SELECT SUM(contagem_bomba) as Soma from bomba;")."</td></tr>";
			    }
			    
				echo "</table>";
			}else if ($selecione == 4){
				echo "<script language='javascript' type='text/javascript'>window.location.href='../4Editar/alterar.php'</script>";
			}else if($selecione == 5){
				echo "<script language='javascript' type='text/javascript'>window.location.href='../5Abastecer/abastecer.php'</script>";
			}
		} ?>
		<fieldset>
				<p><label>CADASTRAR</label></p>
				<?php require("../3Cadastro/cadastro.php"); ?>
		</fieldset>		
	</form>

</body>
</html>
<?php 
require("../Imagens/copyright.php");
mysqli_close($link);?>