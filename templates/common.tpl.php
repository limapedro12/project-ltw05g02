<?php 
  declare(strict_types = 1); 
  $name = 'Dá-lhe Ticket'; 
?>

<?php function drawHeader() { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title><?php global $name; echo $name; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1><a href="/"><?php global $name; echo $name; ?></a></h1>
    </header>

    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>

    <footer>
      <?php global $name; echo $name; ?> &copy; 2023
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm(Session $session) { ?>
  <form action="../actions/action_login.php" method="post" class="login">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <a href="../pages/register.php">Register</a>
    <button type="submit">Login</button>
  </form>

  <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>

<?php } ?>

<?php function drawLogoutForm(Session $session) { ?>
  <form action="../actions/action_logout.php" method="post" class="logout">
    <a href="../pages/profile.php"><?=$session->getName()?></a>
    <button type="submit">Logout</button>
  </form>
<?php } ?>
