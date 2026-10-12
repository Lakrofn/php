<form action="">
    <label>Idioma: </label>
    <select name="option">
        <option value="spanish" <? if (isset($_GET["send"]) && $_GET["option"]=="spanish") echo "selected";?>>Español</option>
        <option value="english" <? if (isset($_GET["send"]) && $_GET["option"]=="english") echo "selected";?>>Inglés</option>
        <option value="french" <? if (isset($_GET["send"]) && $_GET["option"]=="french") echo "selected";?>>Francés</option>
    </select>
    <br><br>
    <button type="submit" name="send">Enviar</button>
    <br><br><br>
    <?
    if (isset($_GET["send"])) {
        if ($_GET["option"] == "spanish") {
            echo "Hola";
        } else if ($_GET["option"] == "english") {
            echo "Hello";
        } else if ($_GET["option"] == "french") {
            echo "Boun your";
        }
    }
    ?>
</form>