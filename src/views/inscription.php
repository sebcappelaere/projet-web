<div class="well" style="text-align:center">
    <h1>Formulaire d'inscription</h1>
</div>

<!-- Afficher les erreurs éventuelles -->
<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger col-md-4 col-md-offset-4">
        <ul>
            <?php foreach ($errors as $item): ?>
                <li> <?= $item ?> </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required class="form-control">
    </div>

    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" required class="form-control">
    </div>

    <div class="form-group">
        <label for="email">Adresse électronique</label>
        <input type="email" name="email" id="premailenom" required class="form-control">
    </div>

    <div class="form-group">
        <label for="mdp" class="la">Mot de passe</label>
        <input type="password" name="mdp" id="mdp" required class="form-control">
    </div>
    <div class="form-group">
        <label for="confirmation-mdp">Mot de passe</label>
        <input type="password" name="confirmation-mdp" id="confirmation-mdp" required class="form-control">
    </div>

    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">Valider</button>
    </div>
</form>