	<form action="cadastro.php" method="POST">
		<p>
			<label>Nome</label>
			<p>
				<input type="text" name="nome" placeholder="Digite o nome...">
			</p>
		</p>
		<p>
			<label>CPF</label>
			<p>
				<input type="text" name="cpf" maxlength="14" placeholder="Digite o CPF...">
			</p>
			<p>
				<select name="sel">
					<option checked>---</option>
						<?php
						$querySELECT = "SELECT g.nome_gerente, e.hora_inicio, e.hora_fim, e.idescala FROM escala as e, gerente as g WHERE e.gerente_idgerente = g.idgerente;";
						$select =  mysqli_query($link, $querySELECT);
						while ($row = mysqli_fetch_assoc($select)) {
							echo "<option value='".$row["idescala"]."'>(".$row["hora_inicio"].") às (".$row["hora_fim"].") => ".$row["nome_gerente"]."</option>";
						}
						?>
				</select>

			</p>
		</p>
		<input type="submit" name="ok1" value="Cadastrar">
	</form>
	</center>
<?php
@$nome = $_POST['nome'];
@$cpf = $_POST['cpf'];
@$selecione = $_POST['sel'];

if (@$_POST["ok1"]) {
	$query = "SELECT cpf_frentista FROM frentista WHERE cpf_frentista= '".$cpf."';";
	$sql = mysqli_query($link,$query) or die("Erro na requisição");
	$array = mysqli_fetch_assoc($sql);
	$logarray = $array['cpf_frentista'];

	if(validaCPF($cpf,"../2MenuPrincipal/index")){
	      if($logarray == $cpf){
	        echo"<script language='javascript' type='text/javascript'>alert('Esse CPF já existe');window.location.href='../2MenuPrincipal/index.php';</script>";
	        die();
	      }else{
	        $insert = "INSERT INTO frentista (nome_frentista,cpf_frentista,escala_idescala,status_frentista) VALUES ('$nome','$cpf','$selecione','1');";
	        if(mysqli_query($link, $insert)){
	          	$CrachaSQL = mysqli_query($link, "SELECT f.*, c.* from frentista as f, cracha as c WHERE f.idfrentista = c.frentista_idfrentista;");
	     		while ($row = mysqli_fetch_assoc($CrachaSQL)) {
	     			echo $row["idfrentista"];
	     			if ($row["cpf_frentista"] == $cpf) {
	     				$aux = rand(1000,9999);
	          			mysqli_query($link, "INSERT INTO cracha values ('".$aux."','".$row["idfrentista"]."')")or die("Erro na query: ".mysqli_error($link));;
	     			}
	     		}  	
	          echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='../2MenuPrincipal/index.php'</script>";
	        }else{
	          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');'</script>";
	          die("Erro na query: ".mysqli_error($link));
        }
      }
    }
}
?>