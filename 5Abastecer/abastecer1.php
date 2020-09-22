<?php
require("../funcoesBanco.php");
session_start();
$link = conecta();
if (@$_POST["ok1"]) {
			$opcao = $_POST["opCombustivel"];
			$valor_pago = $_POST["valor_pago"];
			$query = mysqli_query($link, "SELECT b.*, t.* from tanque as t, bomba as b WHERE t.idtanque = b.tipocombustivel AND b.idbomba = ".$_SESSION["bomba"]." ;");
				
			while ($row = mysqli_fetch_assoc($query)) {
				if ($opcao == $row["idtanque"]) {
					$qtdLitros = $valor_pago / $row["preco_litro"];
				}
			}
			mysqli_query($link, "INSERT into abastecer values('".$qtdLitros."', '".$valor_pago."', '".$opcao."', '".$_SESSION["cracha"]."','".date("H:i")."','".date("d/m/Y")."')") or die(mysqli_error($link));
			$bombaQuery = mysqli_query($link,"SELECT * from bomba;");
			while ($row = mysqli_fetch_assoc($bombaQuery)) {
				if ($row["idbomba"] == $_SESSION["bomba"]) {
					mysqli_query($link, "UPDATE bomba SET contagem_bomba = '".($row["contagem"]+$qtdLitros)."' WHERE idbomba = ".$_SESSION["bomba"]." AND tipocombustivel = ".$opcao.";");
				}
			}
			$tanqueQuery = mysqli_query($link, "SELECT * from tanque;");
			while ($row = mysqli_fetch_assoc($tanqueQuery)) {
				if ($row["idtanque"] == $opcao) {
					mysqli_query($link, "UPDATE tanque SET litragem = '".($row["litragem"]-$qtdLitros)."' WHERE idtanque = ".$opcao.";");
				}
			
		}
	echo "<script type='text/javascript'>alert('VALOR PAGO: R$".$valor_pago." | Qtd de Litros: ".$qtdLitros." | ');windows.location.href='../5Abastecer/abastecer.php'</script>";
} ?>