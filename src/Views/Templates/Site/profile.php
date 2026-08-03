<?php
/**
 * User profile.
 */

/** @var App\Models\User $user */
/** @var App\Models\Book[] $books */
?>

<div class="page-container">
  <div class="profile-page"> 
    <h1>Mon compte</h1>
    <div class="profile">
        <div  class="profile-header">
          <div class="profile-avatar">
            <img src="<?= $user->getAvatar() ?>">
            <a>Modifier</a>
          </div>
          <div class="profile-info">
            <p class="username" ><?= $user->getUsername() ?></p>
            <p class="membership">Membre depuis <span><?= $user->getMembershipDuration() ?></span></p>
            <p class="tiny-uppercase-label">Bibliothèque</p>
            <p class="book-nbr"><span><?= $bookCount ?></span> livres</p>
          </div>
        </div>
      <div  class="profile-edit">
        <p>Vos informations personnelles</p>
            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars(
                    $_SESSION['flash_success'],
                ) ?></div>
                <?php unset($_SESSION['flash_success']); ?>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="index.php?action=updateProfile" method="post" enctype="multipart/form-data"  class="register-login-form">
                <div>
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email" placeholder="<?= $user->getEmail() ?>" value="<?= $user->getEmail() ??
    '' ?>" required>
                </div>
                <div>
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="********" >
                </div>
                <div>
                  <label for="username">Pseudo</label>
                  <input type="text" name="username" id="username" placeholder="<?= $user->getUsername() ?>" value="<?= $user->getUsername() ??
    '' ?>" required>
              </div>
            <button class="submit btn btn-secondary profile-btn">Enregistrer</button>
          </form>
      </div>
    </div>
    <div class="profile-book-list">
      <table>

        <thead>
          <th><p class="tiny-uppercase-label ">Photo</p></th>
          <th><p class="tiny-uppercase-label ">Titre</p></th>
          <th><p class="tiny-uppercase-label ">Auteur</p></th>
          <th><p class="tiny-uppercase-label ">Description</p></th>
          <th><p class="tiny-uppercase-label ">Disponibilité</p></th>
          <th><p class="tiny-uppercase-label ">Action</p></th>
        
        </thead>
        <tbody>
          <?php foreach ($books as $book) { ?>
            <tr>
                <td class=""><img src="<?= $book['image'] ?>"></td>
                <td class=""><a href=""><?= $book['title'] ?></a></td>
                <td class=""><?= $book['author'] ?></td>
                <td class=""><p class="caption book-list-description"><?= $book[
                    'description'
                ] ?></p></td>
                <td><div class="status">Disponible</div></td>
                <td>
                  <div class="action">
                  <p class="edit">Editer</p>
                  <p class="delete">Supprimer</p>
                  </div>
                </td>
            </tr>
          <?php } ?>
        <tbody>
      </table>
    </div>
  </div>
</div>