<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/message.class.php');
    

    $db = getDatabaseConnection();

    $client = $session->getName();
    $title = $_POST['title'];
    $department = $_POST['department'];
    $message = $_POST['message'];

    $ticket = Ticket::createAndAdd($db, $title, $client, $department);
    Message::createAndAdd($db, $ticket->id, true, $message);

    header('Location: ../index.php');
?>