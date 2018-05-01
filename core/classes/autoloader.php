<?php
spl_autoload_register(function ($class) {
    include COREPATH . 'classes/' . ($class). '.php';
});
?>
