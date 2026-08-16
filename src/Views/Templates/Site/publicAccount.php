<?php
/**
 * User public account.
 */

/** @var App\Models\User $user */
/** @var array[] $books */
/** @var int $bookCount */

?>

<div class="page-container">
  <div class="public-account-page"> 
    <div class="account public-account">
        <div  class="account-header public-account-header">
          <div class="account-avatar">
            <img src="<?= htmlspecialchars(
                $user->getAvatar(),
            ) ?>" alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>">
          </div>
          <div class="account-info">
            <p class="username" ><?= $user->getUsername() ?></p>
            <p class="membership">Membre depuis <span><?= $user->getMembershipDuration() ?></span></p>
            <p class="tiny-uppercase-label">Bibliothèque</p>
            <p class="book-nbr"><span><?= $bookCount ?></span> livres</p>
          </div>
          <div>
            <button class="btn btn-secondary public-account-send-message">Envoyer un message</button>
          </div>
        </div>
        <div>
          <?php if ($bookCount > 0): ?>
            <div class="public-account-book-list">
              <table>
                <thead>
                  <tr>
                  <th><p class="tiny-uppercase-label ">Photo</p></th>
                  <th><p class="tiny-uppercase-label ">Titre</p></th>
                  <th><p class="tiny-uppercase-label ">Auteur</p></th>
                  <th><p class="tiny-uppercase-label ">Description</p></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($books as $book) { 
                    $image = $book['image'] !== null && $book['image'] !== '' ? htmlspecialchars($book['image']) : "/assets/images/default-book-cover.jpg";
                    ?>
                    <tr>
                        <td>
                          <a href="index.php?action=book&id=<?= htmlspecialchars($book['id']) ?>">
                            <img src="<?= $image ?>" alt="Image du livre <?= htmlspecialchars($book['title']) ?>">
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

                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
            <?php else : ?>
              <p class="no-book">Pas de livre disponible...</p>
            <?php endif ?>
        </div>
    </div>
    
  </div>
</div>