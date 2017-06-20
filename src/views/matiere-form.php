<div class="well" style="text-align:center">
    <h1>Gestionnaire des matières enseignées</h1>
</div>

<form method="post" class="form-inline">
    <h2>Matière</h2>
    <div class="form-group">
        <input type="text" name="matiere" placeholder="Entrez votre matière" class="form-control" value="<?=$matiere?>">
    </div>
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="hidden" name="token" value="<?=$token?>">
    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">OK</button>
    </div>
</form>