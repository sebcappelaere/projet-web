<!-- Affichage des questions -->
<form method="post">
    <?php $questionIndex = 0; ?>
    <!--boucle sur les questions -->
    <?php foreach ($quiz as $question): ?>
        <div class="col-md-6">
            <h3><?= $question["question"] ?> ?</h3>
            <?php
            $answerIndex = 0;
            ?>
            <!-- boucle sur les réponses -->
            <?php foreach ($question["answers"] as $answer): ?>
                <p>
                    <label>
                        <!-- Affichage de la réponse -->
                        <input
                            type="radio"
                            name="userAnswers[<?= $questionIndex ?>]"
                            <?php
                                $answerIndex++;
                                //Si réponse de l'utilisateur, il faut précocher le bouton radio
                                if(isset($userAnswers[$questionIndex]) && $userAnswers[$questionIndex] ==$answerIndex){
                                    echo " checked ";
                                }
                            ?>
                            value="<?= $answerIndex ?>"
                        >
                        <?= $answer ?>
                    </label>
                </p>
            <?php endforeach; ?>
            <?php $questionIndex++; ?>
        </div>
    <?php endforeach; ?>
    <div class="col-md-12">
        <button class="btn btn-primary" type="submit" name="submit">Valider</button>
    </div>
</form>

<!-- Affichage du résultat du quiz -->
<?php if (count($quizResult) > 0): ?>
    <h3>Vous avez <?=$goodAnswerCount?> bonne(s) réponses sur <?=$questionNumber?></h3>
    <div class="alert alert-info">
        <ul>
            <?php foreach ($quizResult as $item): ?>
                <li><?= $item ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>
