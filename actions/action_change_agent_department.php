<?php

    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    $admin = (User::getUserTypeByUsername($db, $session->getName()) == 'admin');

    if (!$admin || User::getUserTypeByUsername($db, $_POST['username']) != 'agent') {
        header('Location: ../pages/profile.php?username=' . $_GET['username']);
        exit();
    }

    User::changeAgentDep($db, $_POST['username'], $_POST['department']);

    header('Location: ../pages/profile.php?username=' . $_POST['username']);
?>
