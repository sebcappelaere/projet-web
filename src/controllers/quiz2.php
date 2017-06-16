
<?php
// Récupération des données du quiz
$filePath = ROOT_PATH."/src/data/quiz2.json";
$data = json_decode(file_get_contents($filePath), true);
$quiz = $data["quiz"];

//Récupération des réponses de l'utilisateur
$userAnswers = filter_input(INPUT_POST,'userAnswers', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$isSubmitted = filter_has_var(INPUT_POST, 'submit');


$errors = [];
$goodAnswerCount = 0;
$quizResult = [];
$questionNumber = count($quiz);

//Traitement de la réponse de l'utilisateur
if($isSubmitted){
    $answerNumber = count($userAnswers);
    //Erreur si le nombre de réponse ne correspond pas au nombre de questions
    if($answerNumber != $questionNumber){
        $errors[] = "Vous devez répondre à toutes les questions";
    } else {
        //Pour chaque question on compare la réponse de l'utilisateur avec la bonne réponse
        for($i=0; $i< $questionNumber; $i++){

            if($userAnswers[$i] == $quiz[$i]["goodAnswer"]){
                $quizResult[] = "question ".($i+1)." : bonne réponse";
                $goodAnswerCount++;
            } else {
                $quizResult[] = "question ".($i+1)." : mauvaise réponse";
            }
        }
    }
}

//Affichage de la vue
renderView(
    "quiz2",
    [
        "pageTitle" => "Quiz",
        "quiz" => $quiz,
        "quizResult"=>$quizResult,
        "goodAnswerCount"=> $goodAnswerCount,
        "questionNumber"=> $questionNumber,
        "userAnswers" => $userAnswers
    ]

);