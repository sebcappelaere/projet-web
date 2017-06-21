<!DOCTYPE html>

<html>
    <head>
        <title><?= $pageTitle ?></title>
        <!-- Chargement du CSS de Bootstrap -->
        <link rel="stylesheet" href="dependencies/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dependencies/bootstrap/dist/css/bootstrap-theme.min.css">        
        <meta charset="utf-8">
    </head>
    <body class="container-fluid">

        <!-- Navigation principale -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Projet web</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php?controller=inscription-form">Inscription <span
                                    class="sr-only">(current)</span></a></li>
                    <li><a href="index.php?controller=quiz2">Quiz 2</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        //Récupération du rôle de l'utilisateur
                        $role=isset($_SESSION["role"])?$_SESSION["role"]:"";
                        //Récupération du nom de l'utilisateur
                        $userName=isset($_SESSION["userName"])?$_SESSION["userName"]:"Invité";
                    ?>
                    <!-- Dire bonjour à l'utilisateur -->
                    <li class="navbar-text" style="color:blue">Bonjour <?= $userName ?></li>
                    <!-- Affichage du lien connexion/déconnexion -->
                    <?php if ($role == "ADMIN"): ?>
                        <li><a href="index.php?controller=admin-logout">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="index.php?controller=login">Connexion</a></li>
                    <?php endif; ?>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <!-- Affichage des messages flash -->
        <?php if(isset($_SESSION["flash"])): ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 alert alert-info">
                <?php
                    //Affichage du message
                    echo $_SESSION["flash"];
                    //Suppression du message
                    unset($_SESSION["flash"]);
                ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Contenu de l'application -->
        <section class="row">
            <div class="col-md-8 col-md-offset-2">
                <?= $content ?>
            </div>
        </section>

        <script src="dependencies/jquery/dist/jquery.min.js"></script>
        <script src="dependencies/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>