 <?php

    function Status($value)
    {
    	if ($value == 1) {
    		$txt = "Ativo";
    	}else{
    		$txt = "Inativo";

    	}
    	return $txt;
    	
    }
	function matricula($value){
		$txt = date("Y").date("m").date("d").$value;
		return $txt;
	}
	function conecta(){
		$link = mysqli_connect("localhost","root","","posto_de_gasolina") or die("Erro na conexão");
		return $link;
	}
	function formatCnpjCpf($value){
  		$cnpj_cpf = preg_replace("/\D/", '', $value);

  		if (strlen($cnpj_cpf) === 11) {
    	return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
	  	} 
	  
	  	return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
	}

	function validaCPF($cpf = null,$pagina) {
		$i = 2;
		// Verifica se um número foi informado
		if(empty($cpf)) {
		    echo"<script language='javascript' type='text/javascript'>alert('O campo do CPF deve ser preenchido');window.location.href='".$pagina.".php';</script>";
		    return $i;
		}

		// Elimina possivel mascara
		$cpf = preg_replace("/[^0-9]/", "", $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		
		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf) != 11) {
		    echo"<script language='javascript' type='text/javascript'>alert('CPF inválido NUM');window.location.href='".$pagina.".php';</script>";
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
		    echo"<script language='javascript' type='text/javascript'>alert('CPF inválido DÍGITO');window.location.href='".$pagina.".php';</script>";
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
		    echo"<script language='javascript' type='text/javascript'>alert('CPF inválido CODE');window.location.href='".$pagina.".php';</script>";
		    return false;
				}
			}
			return true;
		}
	}
?>