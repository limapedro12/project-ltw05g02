<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/users.tpl.php');

    drawHeader();
    drawUsersList();
    drawFooter();
?>
