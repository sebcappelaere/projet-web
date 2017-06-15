<h1>Bienvenue sur la page Administrateur</h1>


<form method="post" class="form-inline">
    <h2>Nouvelle Compétence</h2>
    <div class="form-group">
        <input type="text" placeholder="Votre compétence à ajouter" name="newCompetence" class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" name="valid" class="btn btn-primary">OK</button>
    </div>
</form>

<h2>Liste des compétences :</h2>

<table class="table table-bordered table-striped">
    <tr>
        <th>Compétence</th>
        <th>Action</th>
    </tr>
    <?php $index=0 ?>
    <?php foreach ($skills as $item): ?>
        <tr>
            <td><?=$item?></td>
            <td>
                <a href="index.php?controller=accueil-admin&itemIndex=<?=++$index?>" class="btn btn-default">
                    <i class="glyphicon glyphicon-trash"></i>
                    Supprimer
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

