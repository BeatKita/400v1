<?php
require_once '../App/Utils/Database/Database.php';

use PERCOLATOR\MinQuiz\Utils\Database\PdoDb;

$bdd = new PdoDb;
$questions = $bdd->requeteRandomQ('question');
$responses = $bdd->requeteSimple('SELECT answer, response.id, question_id FROM response JOIN question on question.id = response.question_id');

$i = 0;

?>  

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="get" action="/score.php" class="text-center">
        <div class="card m-auto" style="width: 18rem;">
            <?php foreach ($questions as $question) {
                $i++ ?>

                <div class="card-body">
                    <h5 class="card-title">Question <?= $i ?>:</h5>
                    <p class="card-text"><?= $question["question"] ?> ?</p>
                </div>
                <ol type="A" id="emptyAnswerSlot" class="list-group list-group-flush btn-group-vertical" role="group" aria-label="Basic radio toggle button group">
                    <?php foreach ($responses as $response) {
                        if ($response["question_id"] == $question["id"]) {
                    ?>
                            <input class="btn-check" type="radio" name="Question <?= $question["id"] ?>" id="<?= $response["id"] ?>" value="<?= $response["id"] ?>">
                            <label class="btn btn-outline-primary" for="<?= $response["id"] ?>">
                                <li><?= $response["answer"] ?></li>
                            </label>
                    <?php }
                    } ?>
                </ol>
            <?php } ?>
            
        </div>
        <div class="m-auto mt-3">
            <input type="submit" value="Envoyer">
        </div>
    </form>
</body> 

</html>