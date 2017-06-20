<h1>Liste des matières enseignées</h1>

<button class="btn btn-primary" name"ajout" type="submit">Ajouter une nouvelle matière</button>
<p></p>

<div class= "col-md-6">
    <table class="table table-bordered table-striped">
        <tr>
            <th>Matières</th>
            <th colspan=2>Action</th>
        <?php $index=0 ?>
        <?php foreach ($listeMatieres as $item): ?>
            <tr>
                <td><?=$item["matiere"]?></td>
                <td>
                    <a href="index.php?controller=matiere-delete&id=<?=$item["matiere_id"]?>" class="btn btn-danger">
                        <i class="glyphicon glyphicon-trash"></i>
                        Supprimer
                    </a>
                </td>
                <td>
                    <a href="index.php?controller=matiere-modif&id=<?=$item["matiere_id"]?>" class="btn btn-primary">Modifier
                    </a>
                    
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
