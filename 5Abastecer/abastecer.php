<?php
session_start();
require("../funcoesBanco.php");
$link = conecta();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../page.css">
	<title>Abastecer</title>
</head>
<body>
	<form action="abastecer.php" method="POST">
		<h1>Abastecer</h1>
		<p>
			<label>Digite o Número do Cracha</label>
			<p>
				<input type="text" name="idcracha" placeholder="Digite o código do cracha...">
			</p>
		</p>
		<p>
			<label>Código da Bomba</label>
			<p>
				<input type="text" name="idbomba" placeholder="Digite o Número identificação da bomba ...">
			</p>
		</p>
		<input type="submit" value="Conectar" name="ok">
	</form>
<?php
	@$botao = $_POST["ok"];
	if ($botao) {
		@$idbomba = $_POST["idbomba"];
		@$cracha = $_POST["idcracha"];
		$query = mysqli_query($link,"SELECT f.*, c.* from cracha as c, frentista as f WHERE f.idfrentista = c.frentista_idfrentista;");
		$pass = false;
		while ($row = mysqli_fetch_assoc($query)) {
			if ($row["idcracha"] == $cracha) {
				$pass = true;
			}
		}
		if ($pass == true) {
			$_SESSION["bomba"] = $idbomba;
			$_SESSION["cracha"] = $cracha;
			?>
		<form action="abastecer1.php" method="POST">
		<p>
				<label>Tipo Combustivel</label>
			</p>
			<select name="opCombustivel">
				<?php
				$query = mysqli_query($link, "SELECT b.*, t.* from tanque as t, bomba as b WHERE t.idtanque = b.tipocombustivel AND b.idbomba = ".$idbomba." ;");
				while ($row = mysqli_fetch_assoc($query)) {
					echo "<option value='".$row["tipocombustivel"]."'>".$row["tipo_combustivel"]."</option>";
				}
				?>
			</select>
		<p>
			<label>Valor Pago</label>
		</p>
			<p>
				<input type="text" name="valor_pago" placeholder="Digite o Valor...">
			</p>
		<input type="submit" name="ok1" value="Abastecer">
	</form>
	</center>
	<?php
	}else{
		echo "<script type='text/javascript'>alert('Frentista não identificado!');</script>";
	}
}
		?>
</body>
</html>