<?php
  declare(strict_types = 1);

  class Hashtag{
    public string $tag;

    public function __construct(string $tag){
      $this->tag = $tag;
    }
    static public function createAndAdd(PDO $db, string $tag){

      $stmt = $db->prepare('
        INSERT INTO Hashtag
        VALUES (?)
      ');
      $stmt->execute(array($tag));

      return new Hashtag($tag);
    }

    static function getAllTicketsWithTag(PDO $db, string $tag) : array {
      $stmt = $db->prepare('
        SELECT t.id, t.client, t.agent, t.status, t.message, t.department
        FROM Ticket t JOIN TicketHashtag th JOIN Hashtag h
        ON th.tag = h.tag AND t.id = th.ticketId
        WHERE h.tag = ?
      ');
      $stmt->execute(array($tag));

      $tickets = array();

      while($ticket = $stmt->fetch()){
        $tickets[] = new Ticket(
          $ticket['id'],
          $ticket['client'],
          $ticket['agent'],
          $ticket['status'],
          $ticket['department']
        );
      }

      return $tickets;
    }

    static function getAllHashtags(PDO $db) : array {
      $stmt = $db->prepare('
        SELECT tag
        FROM Hashtag
      ');
      $stmt->execute();

      $hashtags = array();

      while($hashtag = $stmt->fetch()){
        $hashtags[] = new Hashtag($hashtag['tag']);
      }
      return $hashtags;
    }

    function delete(PDO $db) {
      $stmt = $db->prepare('
        DELETE FROM Hashtag
        WHERE tag = ?
      ');
      $stmt->execute(array($this->tag));
    }

  }
?>