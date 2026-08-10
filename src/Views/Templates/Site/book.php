<?php
/** @var object $book */
?>

<div class="page-container">
    <div class="book-details">
        <img class="book-details-img" src="<?= htmlspecialchars(
            $book->getImage(),
        ) ?>" alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>">
        <article>
            <h1><?= htmlspecialchars($book->getTitle()) ?></h1>
            <div class="detail-author">
                <p>
                    Par <span><?= htmlspecialchars($book->getAuthor()) ?></span>
                </p>
                <p>___</p>
            </div> 
            <p class="tiny-uppercase-label">Description</p>
            <div class="description"><p><?= htmlspecialchars($book->getDescription()) ?></p></div>
            <p class="tiny-uppercase-label">Propriétaire</p>
            <div class="avatar-and-name">
                <img src="<?= htmlspecialchars($book->getUser()->getAvatar()) ?>" alt="avatar">
                <p>
                    <?= htmlspecialchars($book->getUser()->getUsername()) ?>
                </p>
            </div>
            <button class="btn btn-primary">Envoyer un message</button>
        </article>
    </div>
</div>