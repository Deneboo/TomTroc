<?php
/** @var object $book */
?>

<section class="page-container">
    <section class="book-details">
        <img src="<?= htmlspecialchars($book->getImage()) ?>" alt="Image du livre 'Le Petit Prince'">
        <article>
            <h1><?= htmlspecialchars($book->getTitle()) ?></h1>
            <div class="detail-author">
                <p>
                    Par <span><?= htmlspecialchars($book->getAuthor()) ?></span>
                </p>
                <p>___</p>
            </div> 
            <p class="tiny-uppercase-label">Description</p>
            <div class="description">
                <p>
                    <?= htmlspecialchars($book->getDescription()) ?>
                </p>
            </div>
            <p class="tiny-uppercase-label">Propriétaire</p>
            <div class="avatar-and-name">
                <img src="<?= htmlspecialchars($book->getUser()->getAvatar()) ?>" alt="avatar">
                <p>
                    <?= htmlspecialchars($book->getUser()->getUsername()) ?>
                </p>
            </div>
            <button class="btn btn-primary">Envoyer un message</button>
        </article>
    </section>
</section>