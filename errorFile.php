<?php
    if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) === false) {
        header("Location: /");
        exit();
    }
?>