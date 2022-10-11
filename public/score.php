
<?php


require_once '../App/Utils/Database/Database.php';

use PERCOLATOR\MinQuiz\Utils\Database\PdoDb;

$bdd = new PdoDb;
$verif = 0;
print_r($_GET);

foreach ($_GET as $checkedAnswers) {
    $verification = $bdd->requeteSimple("SELECT answer_check FROM response WHERE id = ". $checkedAnswers, "fetch" );
    
     if ($verification["answer_check"] == 1) {
         echo "<br>";
         echo "1 point !";
         $verif++;
    }
}
echo "<br>";
echo $verif;
echo "<br>";

echo ((($verif*100)/6)."%");


?>
