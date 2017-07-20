<?php
//Récupération des données du fichier json
$filePath = ROOT_PATH. '/src/data/quiz.json';
$data = json_decode(file_get_contents($filePath),true);
$quiz = $data['quiz'];

//Récupération des réponses de l'utilisateur





$questions = $quiz[0];
var_dump($questions);
var_dump($questions['question']);
//$parsedData=$data['quiz'];
//var_dump($parsedData);
//$reponses=$parsedData['reponses'];
//var_dump($reponses);

renderView(
    'quiz',
    [
        'pageTitle' => "Quiz",
        'quiz' => $quiz
        
    ]
);