<?php
$start = microtime(true);
require_once __DIR__ . "/../include/modulecheck.php";
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../include/adminlist.php";
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?php echo $config["general"]["desc"]; ?>">
    <meta name="author" content="Wruczek">

    <title><?php echo $config["general"]["title"] . $config["general"]["subtitle"]; ?></title>

    <!-- Icon -->
    <link rel="shortcut icon" href="img/icon/icon-64.png">

    <!-- Bootswatch -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.6/superhero/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <?php if(isset($bansPage)) { ?>
    <!-- DataTables for Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <?php } ?>
    
    <!-- Custom CSS -->
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Nawigacja</span>
                    <i class="fa fa-bars fa-lg" aria-hidden="true"></i>
                </button>
                
                <a class="navbar-brand" href="."><img style="width: 64px;" src="img/icon/icon-64.png" alt="Logo strony"><?php echo $config["general"]["title"]; ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="viewer<?php echo $config["general"]["enablehta"] ? "" : ".php" ?>"><i class="fa fa-eye" aria-hidden="true"></i> Podgląd serwera</a></li>
                    <li><a href="bans<?php echo $config["general"]["enablehta"] ? "" : ".php" ?>"><i class="fa fa-ban" aria-hidden="true"></i> Lista banów</a></li>
                    <!-- Nie mam na to czasu
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-television" aria-hidden="true"></i></i>Ranking <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i>Ranking Aktywności</a></li>
                            <li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i>Ranking Połaczeń</a></li>
                            <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i>Ranking Połączenia</a></li>
                        </ul>
                    </li>
                    -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php foreach ($config["navlinks"] as $navlink) { 
                        $icon = $navlink[0];
                        $text = $navlink[1];
                        $link = $navlink[2]; ?>
                    <li><a href="<?php echo $link; ?>"><i class="fa <?php echo $icon; ?>" aria-hidden="true"></i> <?php echo $text; ?></a></li>
                    <?php } ?>
                    
                    <li data-toggle="tooltip" data-placement="bottom" title="Kontaktuj się z nami pod adresem <?php echo $config["general"]["contactEmail"]; ?>"><a href="mailto:<?php echo $config["general"]["contactEmail"]; ?>"><i class="fa fa-envelope" aria-hidden="true"></i>Kontakt</a></li>
                    
                    <li data-toggle="tooltip" data-placement="bottom" title="Kliknij, by połączyć się z serwerem <?php echo $config['teamspeak']['displayip']; ?>"><a href="ts3server://<?php echo $config['teamspeak']['displayip']; ?>"><i class="fa fa-sign-in" aria-hidden="true"></i>Połącz z serwerem</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="container">

        <div class="row">

            <div class="col-md-3 col-md-push-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i> Status serwera</div>
                    <div class="panel-body">
                        <div class="serverstatus">
                            <p><i class="fa fa-globe" aria-hidden="true"></i> Adres: <a href="ts3server://<?php echo $config['teamspeak']['displayip']; ?>"><?php echo $config['teamspeak']['displayip']; ?></a></p>
                            <div id="serverstatus">
                                <div class="text-center">
                                    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                                    <span class="sr-only">Ładowanie...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-shield" aria-hidden="true"></i> Status administracji <span class="pullright"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Stan na <?php echo $adminlist[1]; ?>"></i></span></div>
                    <div class="panel-body adminlist">
                        <?php echo $adminlist[0]; ?>
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-eye" aria-hidden="true"></i> Podgląd serwera</div>
                    <div class="panel-body">
                        <a href="viewer<?php echo $config["general"]["enablehta"] ? "" : ".php" ?>" class="btn btn-primary btn-lg btn-block"><i class="fa fa-eye" aria-hidden="true"></i> Zobacz &raquo;</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9 col-md-pull-3">