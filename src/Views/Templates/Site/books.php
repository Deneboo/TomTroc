<?php
    /**
     * List books show. 
     */

    /** @var App\Models\Book[] $books */
    var_dump($books);
 
?>

<section class="books">
    <section class="book-list">
        <h1>Nos livres à échanger</h1>
         <ul>
    <?php foreach ($books as $book): ?>
        <li>
            <card class="book-card">
                <img 
                    src="<?= htmlspecialchars($book->getImage()) ?>"
                    alt="Image du livre <?= htmlspecialchars($book->getTitle()) ?>"
                >

                <h4>
                    <?= htmlspecialchars($book->getAuthor()) ?>
                </h4>

                <p>
                    <?= htmlspecialchars($book->getTitle()) ?>
                </p>

                <p class="seller">
                    Vendu par :
                    <span class="seller-name">
                        <?= htmlspecialchars($book->getAuthor()) ?>
                    </span>
                </p>
            </card>
        </li>
    <?php endforeach; ?>
</ul>
    </section>
</section>