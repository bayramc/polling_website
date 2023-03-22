<html>

<head>
    <link rel="stylesheet" href="styles.css">
    <title>Poll Creation Page</title>
</head>

<body>
<h1>Poll creation page</h1>
<form method="post">
   <label for="question">Poll Question:</label>
   <input type="text" id="question" name="question">
   <br>
   <label for="options">Options:</label>
   <input type="text" id="options" name="options[]">
   <input type="text" id="options" name="options[]">
   <input type="text" id="options" name="options[]">
   <br>
   <label for="multiple">Allow multiple selection</label>
   <input type="checkbox" id="multiple" name="multiple" value="true">
   <br>
   
   <label for="deadline">Deadline:</label>
   <input type="date" id="deadline" name="deadline">
   <br>
   <input type="submit" value="Create Poll">
</form>
</body>

<?php
if (isset($_POST["question"]) && isset($_POST["options"]) && isset($_POST["deadline"])) {
    $question = $_POST["question"];
    $options = $_POST["options"];
    $isMultiple = isset($_POST["multiple"]) ? true : false;
    $deadline = $_POST["deadline"];

    // Check if the file exists
    if(!file_exists('polls.json')){
        echo "polls.json file not found";
        exit;
    }

    // Read the JSON file
    $data = json_decode(file_get_contents('polls.json'), true);
    if($data === null){
        echo "polls.json file is empty or invalid json format";
        exit;
    }

    // Add the new poll to the JSON file
    $data["polls"][] = array(
        "id" => uniqid(),
        "question" => $question,
        "options" => $options,
        "isMultiple" => $isMultiple,
        "createdAt" => date("Y-m-d"),
        "deadline" => $deadline,
        "answers" => array(),
        "voted" => array()
    );

    // Save the JSON file
    if(!file_put_contents('polls.json', json_encode($data))){
        echo "Failed to write to polls.json";
        exit;
    }

    header("Location: submit-poll.php");
}

?>

