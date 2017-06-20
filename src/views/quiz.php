<div class="well" style="text-align:center">
    <h1>Quiz</h1>
</div>

<form method="post">
    <div class="form-group">
        <h2>Petit Quiz</h2>
        <h3>Question : </h3><?=$quiz[0]['question']?>
        <h3>Réponses : </h3>
        <?php foreach ($quiz as $item)
        <?=$quiz[0]['reponses'][0]?>
        <ul>
            <?php foreach ($reponses as $item):?>
                <li><?php= $item ?></li>
            <?php endforeach?>
        </ul>
    </div>
</form>