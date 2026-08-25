    <header>
        <nav>
            <div class="logo-link">
                <img src="/assets/images/logo.svg" alt="Logo Tomtroc avec le nom" class="logo">
            </div>
            <div class="nav-container">
                <ul class="nav-left">
                    <li><a href="index.php?action=home">Accueil</a></li>
                    <li><a href="index.php?action=books">Nos livres à échanger</a></li>
                    
                </ul>
                <ul class="nav-right">
                    
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li><a href="index.php?action=messaging"><span><img src="/assets/images/icon-messagerie.png" alt="icone bulle" class="icon-messagerie"></span>Messagerie</a></li>
                        <li><a href="index.php?action=account">Mon compte</a></li>
                        <li><a href="index.php?action=logout">Déconnexion</a></li>
                    <?php } else { ?>
                        <li><a href="index.php?action=registerPage">Inscription</a></li>
                        <li><a href="index.php?action=loginPage">Connexion</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>