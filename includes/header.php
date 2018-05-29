<header>
    <div class="header-left">
        <img id="logo-a2f" src="/images/logo-a2f-blanc-02.svg" height="46">
    </div>
    <div class="header-right noMI">
        <div class="btn bold noMI" onclick="location.href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/disconnect.php'">Déconnexion</div>
    </div>
    <?php
        if ($_SESSION['user']["type"] == 0) {
    ?>
    <div class="header-right mr-1">
        <div class="btn bold noMI" onclick="location.href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/consultant'">Mon profil</div>
    </div>
    <?php
        }
    ?>
    <div class="header-right mr-1">
        <div class="btn bold noMI" onclick="location.href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/recherche'">Recherche</div>
    </div>
    <div class="header-right">
        <div>Bienvenue, <span><?php echo $_SESSION['user']['login']; ?></span></div>
    </div>
</header>