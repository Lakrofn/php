<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="?opcion=1">Ver media <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ejercicio20.php?opcion=2">Ver nota mayor</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="ejercicio20.php?opcion=3">Ver listado de mayores</a>
      </li>
  </div>
</nav>
hola

<?php

  if (isset($_POST["intereses"])){
  var_dump($_POST["intereses"]);
}
?>

<form method ="POST"> 
<p>Intereses (selecciona los que apliquen):</p>
<label><input type="checkbox" name="intereses[]" value="tecnologia" <?php if ($selectInterest == "tecnologia") echo "checked";?>>Tecnología</label>
<br>
<label><input type="checkbox" name="intereses[]" value="deporte" <?php if ($selectInterest == "deporte") echo "checked";?>> Deporte</label>
<br>
<label><input type="checkbox" name="intereses[]" value="lectura" <?php if ($selectInterest == "lectura") echo "checked";?>> Lectura</label>
<br>
<label><input type="checkbox" name="intereses[]" value="viajes" <?php if ($selectInterest == "viajes") echo "checked";?>> Viajes</label>
<br><br>

<?php
  $selectGender = isset($_POST["genero"]) ? $_POST["genero"] :"";
?>

<p>Género:</p>
<label><input type="radio" name="genero" value="hombre" <?php if ($selectGender == "hombre") echo "checked";?>> Hombre</label><br>
<label><input type="radio" name="genero" value="mujer" <?php if ($selectGender == "mujer") echo "checked";?>> Mujer</label><br>
<label><input type="radio" name="genero" value="otro" <?php if ($selectGender == "otro") echo "checked";?>> Otro</label><br><br>

<?php
  $selectCourse = isset($_POST["curso"]) ? $_POST["curso"] :"";
?>

<p>Curso:</p>
<label><input type="radio" name="curso" value="primero" <?php if ($selectCourse == "primero") echo "checked";?>> 1º Daw</label><br>
<label><input type="radio" name="curso" value="segundo" <?php if ($selectCourse == "segundo") echo "checked"; ?>> 2º Daw</label><br>
<label><input type="radio" name="curso" value="otro" <?php if ($selectCourse == "otro") echo "checked"; ?>> Otro</label><br><br>

<label>
País:
<?php
  $selectedCountry = isset($_POST["pais"]) ? $_POST["pais"]: "";
?>
<select name="pais">

  <option value="es" <?php if ($selectedCountry== "es") echo "selected";?> >España</option>
  <option value="mx" <?php if ($selectedCountry== "mx") echo "selected";?> >México</option>
  <option value="ar" <?php if ($selectedCountry== "ar") echo "selected";?> >Argentina</option>
</select>
</label><br><br>

<input type="submit">


</form>