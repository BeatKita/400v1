<?php

require_once '../App/Utils/Database/Database.php';
use PERCOLATOR\MinQuiz\Utils\Database\PdoDb;
$bdd = new PdoDb;
$questions = $bdd->requeteRandomQ('question');
$responses = $bdd->requeteSimple('SELECT question_id, answer FROM response JOIN question on question.id = response.question_id');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>

    <?php
    require_once(__DIR__ . '../../Views/header.php');
    ?>

    <?php
        
    foreach ($questions as $question){
            print_r($question);
            foreach ($responses as $response) {
                if ($response["question_id"] == $question["id"]) {
                print_r($response);
            }
        }
    }    
    ?>

    <?php
    require_once(__DIR__ . '../../Views/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>