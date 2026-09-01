<?php
/** @var bool $hasUnreadMessages */
/** @var int $unreadMessagesCount */
?>
<header>
    <nav>
        <div class="logo-link">
            <img src="/assets/images/site/logo.svg" alt="Logo Tomtroc avec le nom" class="logo">
        </div>
        <div class="nav-container">
            <ul class="nav-left">
                <li><a href="index.php?action=home" class="<?= ($_GET['action'] ?? '') === 'home' ? 'active' : '' ?>">Accueil</a></li>
                <li><a href="index.php?action=books" class="<?= ($_GET['action'] ?? '') === 'books' ? 'active' : '' ?>">Nos livres à échanger</a></li>
                
            </ul>
            <ul class="nav-right">
                
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li>
                        <a href="index.php?action=messaging" class="<?= ($_GET['action'] ?? '') === 'messaging' ? 'active' : '' ?>">
                            <span>
                                <img src="/assets/images/site/icon-messagerie.png" alt="icone bulle" class="icon-messagerie">
                            </span>
                            Messagerie
                            <?php if ($hasUnreadMessages === true) : ?>
                                <span class="unread-message-counter"><?= $unreadMessagesCount ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li><a href="index.php?action=account" class="<?= ($_GET['action'] ?? '') === 'account' ? 'active' : '' ?>">Mon compte</a></li>
                    <li><a href="index.php?action=logout" >Déconnexion</a></li>
                <?php } else { ?>
                    <li><a href="index.php?action=registerPage" class="<?= ($_GET['action'] ?? '') === 'registerPage' ? 'active' : '' ?>">Inscription</a></li>
                    <li><a href="index.php?action=loginPage" class="<?= ($_GET['action'] ?? '') === 'loginPage' ? 'active' : '' ?>">Connexion</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>