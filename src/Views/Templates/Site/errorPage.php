<?php
    /**
     * Error page.
     */

    /** @var string $errorMessage */
?>
<div class="page-container">
    <div class="error-page">
        <h1>Erreur</h1>
        <p><?= $errorMessage ?></p>

        <a href="index.php?action=home">Retour à la page d'accueil</a>
    </div>
</div>
