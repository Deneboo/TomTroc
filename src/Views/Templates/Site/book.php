<?php
/** @var object $book */
?>

<div class="page-container">
    <div class="book-details">
        <img class="book-details-img" src="<?= htmlspecialchars($book->getImage())
            ?? '/assets/images/default-book-cover.jpg' ?>" alt="Couverture du livre <?= htmlspecialchars(
                $book->getTitle(),
            ) ?>">
        <article>
            <h1><?= htmlspecialchars($book->getTitle()) ?></h1>
            <div class="detail-author">
                <p>
                    Par <span><?= htmlspecialchars($book->getAuthor()) ?></span>
                </p>
                <p>___</p>
            </div> 
            <p class="tiny-uppercase-label">Description</p>
                <div class="description"><p><?= htmlspecialchars(
                    $book->getDescription(),
                ) ?></p></div>
            <p class="tiny-uppercase-label">Propriétaire</p>
            <a href="index.php?action=profile&id=<?= $book
                ->getUser()
                ->getId() ?>" class="avatar-and-name">
                <img src="<?= htmlspecialchars($book->getUser()->getAvatar()) ?>" alt="avatar">
                <p>
                    <?= htmlspecialchars($book->getUser()->getUsername()) ?>
                </p>
            </a>
            <?php if ($book->getUser()->getId() !== $_SESSION['user_id']): ?>
                <a href="index.php?action=messaging&id=<?= $book
                    ->getUser()
                    ->getId() ?>" class="btn btn-primary">Envoyer un message</a>
            <?php else: ?>
                <a href="index.php?action=addEditBookForm&id=<?= $book->getId() ?>" class="btn btn-primary">Modifier</a>
            <?php endif; ?>
        </article>
    </div>
</div>