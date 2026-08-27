<?php
/**
 * User public account.
 */

use App\Utils\TextFormat;

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
                    <p class="book-nbr">
                        <img src="/assets/images/site/icon-book.svg" alt="icone livre" class="icon-book">
                        <span><?= $bookCount ?></span> 
                        <?= TextFormat::pluralize(
                            $bookCount,
                            'livre'
                        ) ?>
                    </p>
                </div>
                <div>
                    <?php if (!isset($_SESSION['user_id']) || $user->getId() !== $_SESSION['user_id']): ?>
                        <a href="index.php?action=messaging&id=<?= $user->getId() ?>"
                            class="btn btn-secondary public-account-send-message">
                            Envoyer un message
                        </a>
                    <?php endif; ?>
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
                                    $image
                                        = $book['image'] !== null && $book['image'] !== ''
                                            ? htmlspecialchars($book['image'])
                                            : '/assets/images/site/default-book-cover.jpg'; ?>
                                      <tr>
                                          <td>
                                              <a href="index.php?action=book&id=<?= htmlspecialchars($book['id']) ?>">
                                                  <img src="<?= $image ?>" alt="Image du livre <?= htmlspecialchars(
                                                      $book['title'],
                                                  ) ?>">
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
                                  <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-book">Pas de livre disponible...</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>