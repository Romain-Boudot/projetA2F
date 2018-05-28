<header>
    <div class="header-left">
        <img id="logo-a2f" src="/images/logo-a2f-blanc-02.svg" height="46">
    </div>
    <div class="header-right">
        <div class="btn bold" onclick="location.href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/disconnect.php'">Déconnexion</div>
    </div>
    <div class="header-right">
        <div>Bienvenue, <span><?php echo $_SESSION['user']['login']; ?></span></div>
    </div>
</header>