<?php

$numero = 10;

$contador = 0;

while ($contador < 4) {
    if (isset($_POST["number"])) {
        if ($_POST["number"] > $numero) {
            echo "El numero es menor";
        }elseif($_POST["number"] < $numero){
            echo "El numero es mayor";
        }
    }
}

?>

<form action="" method="post">
    <label>Dime un numero</label>
    <input type="number" name="number">
    <button type="submit">Enviar</button>
</form>