<?php
/**
 * List books show.
 */

/**@var App\Models\Book[] $books */
?>

<div class="page-container">
    <div class="book-list">
        <div class="title">
            <h1>Nos livres à échanger</h1>
            <div class="search-input">
        <button type="submit" class="search-button" aria-label="Rechercher">
            <img src="/assets/images/lens.png" alt="">
        </button>

        <input
            type="text"
            name="search"
            id="search"
            placeholder="Rechercher un livre"
        >
    </div>
        </div>
        
         <ul>
    <?php foreach ($books as $book):
        if (htmlspecialchars($book->getIsAvailable()) === '1'): 
        ?>
        <li>
            <a class="book-card" href="index.php?action=book&id=<?= $book->getId() ?>">
                <img 
                    src="<?= htmlspecialchars($book->getImage()) ?>"
                    alt="Image du livre <?= htmlspecialchars($book->getTitle()) ?>"
                >

                <p class="heading-3">
                    <?= htmlspecialchars($book->getAuthor()) ?>
                </p>

                <p>
                    <?= htmlspecialchars($book->getTitle()) ?>
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