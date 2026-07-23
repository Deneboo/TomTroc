<?php
    /**
     * List books show. 
     */

    /** @var App\Models\Book[] $books */

?>

<section class="page-container">
    <section class="book-list">
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
    <?php foreach ($books as $book): ?>
        <li>
            <card class="book-card">
                <img 
                    src="<?= htmlspecialchars($book['image']) ?>"
                    alt="Image du livre <?= htmlspecialchars($book['title']) ?>"
                >

                <h4>
                    <?= htmlspecialchars($book['author']) ?>
                </h4>

                <p>
                    <?= htmlspecialchars($book['title']) ?>
                </p>

                <p class="seller">
                    Vendu par :
                    <span class="seller-name">
                        <?= htmlspecialchars($book['username']) ?>
                    </span>
                </p>
            </card>
        </li>
    <?php endforeach; ?>
</ul>
    </section>
</section>