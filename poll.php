<html>

<head>
    <link rel="stylesheet" href="styles.css">
    <title>Poll Page</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["username"])) {
        $polls = json_decode(file_get_contents("polls.json"), true);
        $pollId = $_GET["id"];
        $poll = null;
        foreach ($polls["polls"] as $p) {
            if ($p["id"] == $pollId) {
                $poll = $p;
                break;
            }
        }
        if ($poll) {
            $username = $_SESSION["username"];
            if (!in_array($username, $poll["voted"])) {
                echo '<div class="poll-box">';
                echo '<h1>' . $poll["question"] . '</h1>';
                echo '<form action="submit-vote.php" method="post">';
                foreach ($poll["options"] as $option) {
                    echo '<input type="radio" name="vote" value="' . $option . '"> ' . $option . '<br>';
                }
                echo '<input type="hidden" name="poll-id" value="' . $pollId . '">';
                echo '<input type="submit" value="Vote">';
                echo '</form>';
                echo '</div>';
            } else {
                header("Location: alreadyvoted.php");            }
        } else {
            echo '<p>Invalid poll ID.</p>';
        }
    } else {
        echo '<p>Please <a href="login.php">log in</a> to vote in a poll.</p>';
    }
    ?>
</body>

</html>