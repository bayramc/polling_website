<html>

<head>
    <link rel="stylesheet" href="styles.css">
    <title>Successful Vote</title>
</head>

<body>
    <h1>Thank you for voting!</h1>
    <br>

    <form action="index.php" method="post">
    <input type="submit" value="Back to home page!">

</body>

<?php
session_start();

if (isset($_POST["vote"]) && isset($_POST["poll-id"])) {
  $polls = json_decode(file_get_contents("polls.json"), true);
  $pollId = $_POST["poll-id"];
  $vote = $_POST["vote"];
  $poll = null;
  foreach ($polls["polls"] as &$p) {
    if ($p["id"] == $pollId) {
      $poll = &$p;
      break;
    }
  }
  if ($poll) {
    $username = $_SESSION["username"];

    // Check if the user has already voted
    if (in_array($username, $poll["voted"])) {
        echo "You have already voted in this poll.";
    } else {
        // Add the user's vote to the poll's answers
        if(array_key_exists($vote, $poll["answers"])) {
            $poll["answers"][$vote] += 1;
        } else {
            $poll["answers"][$vote] = 1;
        }
        // Add the user to the list of users who have voted in the poll
        array_push($poll["voted"], $username);
        file_put_contents("polls.json", json_encode($polls));
    }
  } else {
    echo "Poll not found.";
  }
} else {
  echo "Invalid vote or poll ID.";
}

?>