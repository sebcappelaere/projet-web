<div class="well" style="text-align:center">
    <h1>Identification</h1>
</div>

<!-- Affichage des erreurs -->
<?php if(count($errors)>0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors as $item): ?>
                <li> <?=$item?> </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label>Votre identifiant</label>
        <input type="text" name="login" class="form-control" value="<?=$login?>">
    </div>
    <div class="form-group">
        <label>Votre mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">Valider</button>
    </div>
</form>
