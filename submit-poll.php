<html>

<head>
    <link rel="stylesheet" href="styles.css">
    <title>Successful Poll Creation</title>
</head>

<body>
    <h1>Thank you for creating a new poll!</h1>
    <br>

    <form action="" method="post">
    <input type="submit" name="backhome" value="Back to home page!">

</body>

<?php

if (isset($_POST["backhome"]))
{
    header("Location: adminindex.php");
}

?>
