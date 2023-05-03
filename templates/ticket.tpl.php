<?php
    declare(strict_types = 1); 

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/hashtag.class.php');
    require_once(__DIR__ . '/../database/message.class.php');
?>

<?php function drawTicketList(array $tickets) : void {
    if (sizeof($tickets) == 0) {
        print "You have no tickets.";
        return;
    }
    ?>
    <ul class="ticket_list">
    <?php foreach ($tickets as $ticket) {?>
        <li><a href="../pages/ticket.php?id=<?= $ticket->id?>">[<?= $ticket->status?>] <?= $ticket->title?></a></li>
    <?php }?>
    </ul>
<?php }?>

<?php function drawTicket(PDO $db, Ticket $ticket) { 
    $session = new Session();
    $me = User::getUserByUsername($db, $session->getName());
    ?>
    <h3><?= $ticket->title ?></h3>
    <div class="ticket_client"><span class="bold">Client:</span> <?= $ticket->client ?></div>
    <?php if($ticket->agent !== null) { ?>
        <div class="ticket_agent"><span class="bold">Agent:</span> <?= $ticket->agent ?></div>
    <?php } ?>
    <div class="ticket_status"><span class="bold">Status:</span> <?= $ticket->status ?></div>
    <div class="ticket_department"><span class="bold">Department:</span> <?= $ticket->department ?></div>
    <div class="ticket_hashtags"><span class="bold">Hashtags: </span>  
        <?php foreach($ticket->getHashtags($db) as $hashtag) { ?>
            <span class="hashtag">#<?= $hashtag->name ?></span>  
        <?php } ?>
    </div>

    <?php if($ticket->agent == $session->getName()) { ?>
        <a href=<?=("../actions/action_abandon_ticket.php?id=" . $ticket->id)?>>
            Abandon Ticket
        </a>
    <?php
        } else if ($ticket->status == 'Unsolved' && $ticket->agent == null) {
            if ($me->department == $ticket->department) {
    ?> 
        <a href=<?=("../actions/action_assign_ticket.php?id=" . $ticket->id . "&agent=" . $session->getName())?>>
            Assign ticket to myself
        </a>
    <?php
            }
        }
        if ($me->type == 'admin' && $ticket->status == 'Unsolved') {
?>
        <a href="../pages/assign_ticket.php?id=<?= $ticket->id ?>">Assign ticket...</a>
<?php
        } if ($ticket->agent != null && $ticket->status == 'Unsolved' && $me->type == 'admin') {
?>
        <a href=<?=("../actions/action_abandon_ticket.php?id=" . $ticket->id)?>>
            Unassign ticket
        </a>
<?php
        }
        if ($me->type == 'admin' || $ticket->agent == $me->username) {
?>
        <a href="../actions/action_change_ticket_status.php?id=<?= $ticket->id ?>">
            Mark as <?= $ticket->status == 'Unsolved'? 'Solved' : 'Unsolved' ?>
        </a>
<?php
        }
    ?>
    <div class="ticket_message_field">
        <div class="ticket_messages">
<?php
    foreach(Message::getAllMessagesFromTicket($db, $ticket->id) as $message) { ?>
            <div class="ticket_message <?= $message->isMine($db) ? 'right' : 'left' ?>">
                <div class="ticket_message_text"><?= $message->message ?></div>
                <div class="ticket_message_date"><?= $message->date ?></div>
            </div>
        <?php }
        ?>
        </div>
<?php
    if (($ticket->client == $me->username || $ticket->agent == $me->username) && $ticket->status == 'Unsolved') {
        ?>
        <form class="send_message" action="../actions/action_send_message.php" method=post>
            <input type="hidden" name="ticketId" value="<?= $ticket->id ?>">
            <input type="hidden" name="isFromClient" value="<?= $ticket->client == $session->getName() ? "true" : "false" ?>">
            <input type="text" name="message" class="message" placeholder="Message">
            <button type="submit">Send</button>
        </form>
    </div>
<?php 
    }
} 
?>
