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
                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Link</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

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