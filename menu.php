    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="AppManager.php">
                    <img alt="logo" class="navbar-logo" src="resources/logo.png">
                  </a>
            </div>

            <ul class="nav navbar-nav navbar-right hidden-xs right-sesion">
                <li><a>Bienvenido: <span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['user']["name"]." ".$_SESSION['user']["last"] ?></a></li>

                <li><a href="?p=logout"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
            </ul>
        </div>
    </div>
    <nav class="navbar menu-bar navbar-default sidebar menu-side navbar-fixed-top" role="navigation">
        <div class="container-fluid menu-side-top">
            <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
                <ul class="nav navbar-nav aside-menu">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle hidden-sm hidden-md hidden-lg" data-toggle="dropdown"> Bienvenido: <?php echo $_SESSION['user']["name"]." ".$_SESSION['user']["last"] ?> <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">

                            <li><a href="?p=logout"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>

                        </ul>
                    </li> 

                    <li><a href="?p=products"> Productos <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-shopping-cart"></span></a></li>
                    <li><a href="?p=publicity"> Publicidad <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-modal-window"></span></a></li>
                    <li><a href="?p=notification"> Notificaciones <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-bell"></span></a></li>
                    <li><a href="?p=sales"> Ventas <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-piggy-bank"></span></a></li>
               </ul>
            </div>
        </div>
    </nav>