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
                <?php endif; ?>
            </form>
        </div>
        
        <ul>
            <?php foreach ($books as $book):
                $image = $book->getImage() !== '' && $book->getImage() !== null ? htmlspecialchars($book->getImage()) : "/assets/images/default-book-cover.jpg";
                if (htmlspecialchars($book->isAvailable()) === '1'): ?>
                <li>
                    <a class="book-card" href="index.php?action=book&id=<?= $book->getId() ?>">
                        <img 
                            src="<?= $image ?>"
                            alt="Image du livre <?= htmlspecialchars($book->getTitle()) ?>"
                        >

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
            <?php endif;
            endforeach; ?>
        </ul>
    </div>
</div>