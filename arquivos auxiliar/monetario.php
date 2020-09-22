<?php
$num = 100000.50;


// repare que o padrão é no formato americano

echo 'R$' . number_format($num, 2)."<br>"; // retorna R$100,000.50


// nosso formato

echo 'R$' . number_format($num, 2, ',', '.')."<br>"; // retorna R$100.000,50


//formato americano

echo 'R$' . number_format($num, 2, '.', ','); // retorna R$100,000.50

?>