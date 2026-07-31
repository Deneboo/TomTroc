<section class="page-container">
    <section class="register-login">
  <div class="form-section">
    <h1>Inscription</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="index.php?action=registerPost"  method="post" enctype="multipart/form-data"  class="register-login-form">
        <div>
            <label for="username">Pseudo</label>
            <input type="text" name="username" value="<?= htmlspecialchars($old_username ?? '') ?>" id="username" minlength="3" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($old_email ?? '') ?>" id="email" required>
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                required
            >
        </div>
        <button class="submit btn btn-primary">S'enregistrer</button>
    </form>
    <p>Déja inscrit ? <span><a href="index.php?action=login">Connectez-vous</a></span></p>
  </div>
  <img src="/assets/images/library-vintage.jpg" alt="image de livres">
    </section>
</section>