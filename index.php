<html>

<head>
  <link rel="stylesheet" href="styles.css">
  <title>Home Page</title>

</head>
<?php
session_start();
?>

<?php
if (isset($_SESSION["username"])) {
  ?>

  <body>
    <h1>Welcome <?php echo $_SESSION["username"]; ?>!</h1>
    <div id="active-polls">
      <h2>Active Polls</h2>
      <?php
      if (isset($_SESSION["username"])) {
        ?>
        <ul>
          <?php
          $polls = json_decode(file_get_contents("polls.json"), true);
          $activePolls = array();
          $inactivePolls = array();
          foreach ($polls["polls"] as $poll) {
            $currentDate = date("Y-m-d");
            if ($poll["deadline"] >= $currentDate) {
              array_push($activePolls, $poll);
            } else {
              array_push($inactivePolls, $poll);
            }
          }
          usort($activePolls, function ($a, $b) {
            return strtotime($b["createdAt"]) - strtotime($a["createdAt"]);
          });
          foreach ($activePolls as $poll) {
            echo '<li><a href="poll.php?id=' . $poll["id"] . '"> <strong>' . $poll["question"] . ' <br> • Created: ' . $poll["createdAt"] . ' • Due: ' . $poll["deadline"] . ' • Poll ID: ' . $poll["id"] . '</strong> </a>';
            if (isset($poll["voted"]) && in_array($_SESSION["username"], $poll["voted"])) {
              echo '<span>✅</span>';
            }
            echo '</li>';
            echo '<ul style="list-style: none;">';
            foreach ($poll["options"] as $option => $votes) {
              echo '<li>' . $votes . '</li>';
            }
            echo '</ul>';
            echo '<br>';
          }
          ?>
        </ul>
        <?php
      } else {
        ?>
        <?php
      }
      ?>

    </div>
    <div id="inactive-polls">
      <h2>Inactive Polls</h2>
      <ul>
        <?php
        usort($inactivePolls, function ($a, $b) {
          return strtotime($b["createdAt"]) - strtotime($a["createdAt"]);
        });
        foreach ($inactivePolls as $poll) {
          echo '<li><strong>' . $poll["question"] .  '</strong></li>';
          echo '<strong>Closed on: ' . $poll["deadline"] . '</strong>';
          echo '<ul style="list-style: none;">';
          foreach ($poll["answers"] as $option => $votes) {
            echo '<li>' . $option . ': ' . $votes . ' votes</li>';
          }
          echo '</ul>';
          echo '<br>';
          echo '<br>';
        }
        ?>
      </ul>
    </div>
    <br>
    <form action="logout.php" method="post">
      <input type="submit" value="Log Out">
    </form>
    <br>

  </body>

  </html>

<?php } else { ?>

  <body>
    <h1>Welcome stranger!</h1>

    <div id="active-polls">
      <h2>Active Polls</h2>
      <h4 class="error">You will be redirected to the log in page when you click on a poll!</h4>
      <?php

      ?>
      <ul>
        <?php
        $polls = json_decode(file_get_contents("polls.json"), true);
        $activePolls = array();
        $inactivePolls = array();
        foreach ($polls["polls"] as $poll) {
          $currentDate = date("Y-m-d");
          if ($poll["deadline"] >= $currentDate) {
            array_push($activePolls, $poll);
          } else {
            array_push($inactivePolls, $poll);
          }
        }
        usort($activePolls, function ($a, $b) {
          return strtotime($b["createdAt"]) - strtotime($a["createdAt"]);
        });
        foreach ($activePolls as $poll) {
          echo '<li><a href="login.php?id=' . $poll["id"] . '"> <strong>' . $poll["question"] . ' <br> • Created: ' . $poll["createdAt"] . ' • Due: ' . $poll["deadline"] . ' • Poll ID: ' . $poll["id"] . '</strong></a></li>';
          echo '<ul style="list-style: none;">';
          foreach ($poll["options"] as $option => $votes) {
            echo '<li>' . $votes . '</li>';
          }
          echo '</ul>';
          echo '<br>';
        }
        ?>
      </ul>
      <?php

      ?>

    </div>
    <div id="inactive-polls">
      <h2>Inactive Polls</h2>
      <ul>
        <?php
        usort($inactivePolls, function ($a, $b) {
          return strtotime($b["createdAt"]) - strtotime($a["createdAt"]);
        });
        foreach ($inactivePolls as $poll) {
          echo '<li><strong>' . $poll["question"] . '</strong></li>';
          echo '<strong>Closed on: ' . $poll["deadline"] . '</strong>';

          echo ' <br><strong><span class="error">Log in to see the result of the poll! </span></strong>'; 
          echo '<br>';
          echo '<br>';
        }
        ?>
      </ul>
    </div>
    <br>
    <form action="login.php" method="post">
      <input type="submit" value="Log in">
    </form>
    <br>

  <?php } ?>