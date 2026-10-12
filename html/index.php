<?php
    if(isset($_GET['edad'])){
        $years = $_GET['edad'];
        if($years < 18){
            $adult = "Eres menor de edad";
        }else{
            $adult = "Eres mayor de edad";
        }
    }
?>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<br>
<form>
    <div class="form-group row">
        <? if(isset($adult)){ ?>
            <label class="col-4 col-form-label" for="edad"><?php echo $adult ?></label>
            
        <? } ?>
        <div class="col-8">
            <input id="edad" name="edad" placeholder="introduzca aquí su edad" type="number" class="form-control">
        </div>

    </div> 
    <div class="form-group row">
        <div class="offset-4 col-8">
        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

<? if(isset($years)){ ?>
<ul>
    <? for($i=1;$i<=10;$i++): ?>
    <li><? echo $years * $i ?></li>
    <? endfor?>
</ul>
<? } ?>


