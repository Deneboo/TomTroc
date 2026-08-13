<?php
/**
 * Add or edit book template.
 */
/** @var object $book */

?>

<div class="page-container">
    <section class="add-edit-book-page">
        <h1>
            <?= isset($book) ? 'Modifier le livre' : 'Ajouter un livre' ?>
        </h1>
        <div class="add-edit-book-card">
            <div class="add-edit-book-img">
            <form class="add-edit-book-form" action="index.php?action=uploadImage" method="post" enctype="multipart/form-data">
                <div>
                    <label for="fileToUpload">
                        Photo
                    </label>
                    <?php if ($book->getImage() !== null): ?>
                        <img class="book-form-img" src="<?= isset($book)
                        ? htmlspecialchars($book->getImage())
                        : 'https://via.placeholder.com/150' ?>" alt="Couverture du livre <?= isset(
                                $book,
                            )
                        ? htmlspecialchars($book->getTitle())
                        : '' ?>">
                    <?php else: ?>
                        <img
                            src="/assets/images/default-book-cover.jpg"
                            alt="<?= htmlspecialchars($book->getTitle()) ?>"
                        >
                    <?php endif; ?>
                </div>
                <label for="fileToUpload" class="btn-img" style="cursor: pointer;">
                    Modifier la photo
                </label>
                <input
                    type="hidden"
                    name="id"
                    value="<?= $book->getId() ?>"
                >
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="this.form.submit()" value="<?= $book->getId() ?>" style="display: none;">
            </form>
            <?php if (isset($_SESSION['flash_error_upload_book_cover'])): ?>
                <div class="alert alert-book-cover alert-danger">
                    <?= htmlspecialchars($_SESSION['flash_error_upload_book_cover']) ?>
                </div>
                <?php unset($_SESSION['flash_error_upload_book_cover']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['flash_success_upload_book_cover'])): ?>
                <div class="alert alert-book-cover alert-success"><?= htmlspecialchars(
                    $_SESSION['flash_success_upload_book_cover'],
                ) ?>
                </div>
                <?php unset($_SESSION['flash_success_upload_book_cover']); ?>
            <?php endif; ?>
            </div>
            <form class="add-edit-book-form form-details" method="post" action="index.php?action=addEditBookPost" enctype="multipart/form-data">
                <?php if (!empty($book->getId())): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($book->getId()) ?>">
                <?php endif; ?>
                <div>
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" value="<?= isset($book)
                                                ? htmlspecialchars($book->getTitle())
                                                : '' ?>" required>
                </div>
                <div>
                    <label for="author">Auteur</label>
                    <input type="text" id="author" name="author" value="<?= isset($book)
                                                ? htmlspecialchars($book->getAuthor())
                                                : '' ?>" required>
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea id="description" class="text-area" name="description" required><?= htmlspecialchars(
                        isset($book) ? $book->getDescription() : '',
                    ) ?></textarea>
                </div>
                <div>
                    <label for="isAvailable">Disponible :</label>
                    <select id="isAvailable" name="isAvailable">
                        <!-- <option value="" disabled selected>-- Choisissez une option --</option> -->
                        <option value="1" <?= $book->getIsAvailable() ? selected : '' ?>>Disponible</option>
                        <option value="0">Non dispo.</option>
                    </select>
                </div>
                <button type="submit" class="submit btn btn-form btn-primary"><?= isset($book)
                    ? 'Modifier'
                    : 'Ajouter' ?></button>
            </form>
        </div>
    </section>
</div>