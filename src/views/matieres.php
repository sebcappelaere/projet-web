<div class="well" style="text-align:center">
    <h1>Liste des matières enseignées</h1>
</div>

<a  href="index.php?controller=matiere-form" class="btn btn-primary">Ajouter une nouvelle matière</a>
<p></p>

<div class= "col-md-6 col-md-offset-3" style="text-align:center">
    <table class="table table-bordered table-striped">
        <tr>
            <th style="text-align:center">Matières</th>
            <th style="text-align:center">Action</th>
        <?php $index=0 ?>
        <?php foreach ($listeMatieres as $item): ?>
            <tr>
                <td><?=$item["matiere"]?></td>
                <td>
                    <a href="index.php?controller=matiere-delete&id=<?=$item["matiere_id"]?>" class="btn btn-danger">
                        <i class="glyphicon glyphicon-trash"></i>
                        Supprimer
                    </a>
                    <a href="index.php?controller=matiere-form&id=<?=$item["matiere_id"]?>" class="btn btn-primary">
                        <i class="glyphicon glyphicon-refresh"></i>
                        Modifier
                    </a>
                    
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
