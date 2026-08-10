<?php
/**
 * User profile.
 */

/** @var App\Models\User $user */
/** @var array[] $books */
?>

<div class="page-container">
  <div class="profile-page"> 
    <h1>Mon compte</h1>
    <div class="profile">
        <div  class="profile-header">
          <div class="profile-avatar">
            <img src="<?= htmlspecialchars(
                $user->getAvatar(),
            ) ?>" alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>">
            <form action="index.php?action=uploadAvatar" method="post" enctype="multipart/form-data">
              <label for="fileToUpload" class="avatar-label" style="cursor: pointer;">
                Modifier
              </label>
              <input type="file" name="fileToUpload" id="fileToUpload" onchange="this.form.submit()" style="display: none;">
            </form>
              <?php if (isset($_SESSION['flash_error_upload_file'])): ?>
                <div class="alert-avatar alert-danger">
                  <?= htmlspecialchars($_SESSION['flash_error_upload_file']) ?>
                </div>
                <?php unset($_SESSION['flash_error_upload_file']); ?>
              <?php endif; ?>
            <?php if (isset($_SESSION['flash_success_upload_file'])): ?>
                <div class="alert-avatar alert-success"><?= htmlspecialchars(
                    $_SESSION['flash_success_upload_file'],
                ) ?></div>
                <?php unset($_SESSION['flash_success_upload_file']); ?>
            <?php endif; ?>
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
            <?php if (isset($_SESSION['flash_success_info'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars(
                    $_SESSION['flash_success_info'],
                ) ?></div>
                <?php unset($_SESSION['flash_success_info']); ?>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="index.php?action=updateProfile" method="post" enctype="multipart/form-data"  class="register-login-form">
                <div>
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars(
                        $user->getEmail(),
                    ) ?? '' ?>" required>
                </div>
                <div>
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="********" >
                </div>
                <div>
                  <label for="username">Pseudo</label>
                  <input type="text" name="username" id="username" value="<?= htmlspecialchars(
                      $user->getUsername(),
                  ) ?? '' ?>" required>
              </div>
            <button class="submit btn btn-secondary profile-btn">Enregistrer</button>
          </form>
      </div>
    </div>
    <div class="profile-book-list">
      <table>

        <thead>
          <tr>
          <th><p class="tiny-uppercase-label ">Photo</p></th>
          <th><p class="tiny-uppercase-label ">Titre</p></th>
          <th><p class="tiny-uppercase-label ">Auteur</p></th>
          <th><p class="tiny-uppercase-label ">Description</p></th>
          <th><p class="tiny-uppercase-label ">Disponibilité</p></th>
          <th><p class="tiny-uppercase-label ">Action</p></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book) { ?>
            <tr>
                <td>
                  <a href="index.php?action=book&id=<?= htmlspecialchars($book['id']) ?>">
                    <img src="<?= htmlspecialchars(
                        $book['image'],
                    ) ?>" alt="Image du livre <?= htmlspecialchars($book['title']) ?>">
                  </a>
                </td>
                <td>
                  <a href="index.php?action=book&id=<?= htmlspecialchars($book['id']) ?>">
                    <?= htmlspecialchars($book['title']) ?>
                  </a>
                </td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td>
                  <p class="book-list-description">
                    <?= htmlspecialchars($book['description']) ?>
                  </p>
                </td>
                <td>
                  <div class="status <?= htmlspecialchars($book['is_available']) === '1'
                      ? 'available'
                      : 'unavailable' ?>">
                  <?= htmlspecialchars($book['is_available']) === '1'
                      ? 'disponible'
                      : 'non dispo.' ?>
                </div>
              </td>
                <td>
                  <div class="action">
                  <a class="edit" href="index.php?action=addEditBook&id=<?= htmlspecialchars(
                      $book['id'],
                  ) ?>">Editer</a>
                  <a class="delete" href="index.php?action=deleteBook&id=<?= htmlspecialchars(
                      $book['id'],
                  ) ?>">Supprimer</a>
                  </div>
                </td>
            </tr>
          <?php } ?>
            </tbody>
      </table>
    </div>
  </div>
</div>