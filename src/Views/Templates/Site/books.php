<?php
/**
 * List books show.
 */

/** @var array[] $books */
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
        if (htmlspecialchars($book['is_available']) === '1') { ?>

       
        <li>
            <a class="book-card" href="index.php?action=book&id=<?= $book['id'] ?>">
                <img 
                    src="<?= htmlspecialchars($book['image']) ?>"
                    alt="Image du livre <?= htmlspecialchars($book['title']) ?>"
                >

                <p class="heading-3">
                    <?= htmlspecialchars($book['author']) ?>
                </p>

                <p>
                    <?= htmlspecialchars($book['title']) ?>
                </p>

                <p class="seller">
                    Vendu par :
                    <span class="seller-name">
                        <?= htmlspecialchars($book['username']) ?>
                    </span>
                </p>
            </a>
        </li>
    <?php }
        endforeach; ?>
</ul>
    </div>
</div>