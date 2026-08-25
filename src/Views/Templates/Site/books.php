<?php
/**
 * List books show.
 */

/**@var App\Models\Book[] $books */
/**@var App\Models\Book $book */
?>

<div class="page-container">
    <div class="book-list">
        <div class="title">
            <h1>Nos livres à échanger</h1>
            <form method="get" action="index.php"  class="search-input">
                <button type="submit" class="search-button" aria-label="Rechercher">
                    <img src="/assets/images/lens.png" alt="">
                </button>
                <input type="hidden" name="action" value="search" >
                <input 
                    type="text" 
                    name="title" 
                    placeholder="Rechercher un livre par titre"
                    value="<?= htmlspecialchars($_GET['title'] ?? '') ?>"
                >
                <?php
                    $hasSearchQuery = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
                    if (!empty($hasSearchQuery)): ?>
                    <a href="index.php?action=books" class="search-clear">×</a>
                <?php endif;
                ?>
            </form>
        </div>
        <ul>
            <?php foreach ($books as $book):
                $image
                    = $book->getImage() !== '' && $book->getImage() !== null
                        ? htmlspecialchars($book->getImage())
                        : '/assets/images/default-book-cover.jpg';
                ?>
                <li>
                   <a class="book-card"
                        href="<?= $book->isAvailable() ? 'index.php?action=book&id=' . $book->getId() : '#' ?>"
                    >
                        <div class="book-image">
                            <img 
                                src="<?= $image ?>"
                                alt="Image du livre <?= htmlspecialchars($book->getTitle()) ?>"
                            >
                            <?php if (!$book->isAvailable()): ?>
                                <span class="unavailable">Non dispo.</span>
                            <?php endif; ?>
                        </div>
                        <p class="heading-3">
                            <?= htmlspecialchars($book->getTitle()) ?>
                        </p>
                        <p class="author">
                            <?= htmlspecialchars($book->getAuthor()) ?>
                        </p>
                        <p class="seller">
                            Vendu par :
                            <span class="seller-name">
                                <?= htmlspecialchars($book->getUser()->getUsername()) ?>
                            </span>
                        </p>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>