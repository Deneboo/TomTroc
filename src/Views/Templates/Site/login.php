<div  class="page-container">
  <div class="register-login">
  <div class="form-section">
    <h1>Connexion</h1>
      <form  action="index.php?action=login" method="post" class="register-login-form">
        <div>
            <label for="email">Adresse email</label>
            <input type="email" name="email" id="email" required>
            </div>
            <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            </div>
            <button class="submit btn btn-primary">Se connecter</button>
        </form>
        <p class="redirect-to">Pas de compte ? <span><a href="index.php?action=registerPage">Inscrivez-vous</a></span></p>
  </div>
  <img class="register-login-img" src="/assets/images/library-vintage.jpg" alt="image de livres">
  </div>
</div>