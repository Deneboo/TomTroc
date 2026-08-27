<?php
/**
 * Add or edit book template.
 */
/** @var object $book */

$id = $book ? htmlspecialchars($book->getId()) : '';
$image
    = $book && $book->getImage() !== ''
        ? htmlspecialchars($book->getImage())
        : '/assets/images/site/default-book-cover.jpg';
$title = $book ? htmlspecialchars($book->getTitle()) : '';
$author = $book ? htmlspecialchars($book->getAuthor()) : '';
$description = $book ? htmlspecialchars($book->getDescription()) : '';

$available = $book ? $book->isAvailable() : 0;
?>

<div class="page-container">
    <section class="add-edit-book-page">
        <h1>
            <?= isset($book) ? 'Modifier le livre' : 'Ajouter un livre' ?>
        </h1>
        <div class="add-edit-book-card">
            <div>
                <form class="add-edit-book-form" action="index.php?action=uploadImage" method="post" enctype="multipart/form-data">
                    <div>
                        <p class="title-photo">
                            Photo
                        </p>
                        <img class="book-form-img" src="<?= $image ?>" alt="Couverture du livre <?= $title ?>">
                    </div>
                    <?php if ($book): ?>
                        <label for="fileToUpload" class="btn-img" style="cursor: pointer;">
                            Modifier la photo
                        </label>
                    <?php endif; ?>
                    <input
                        type="hidden"
                        name="id"
                        value="<?= $id ?>"
                    >
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange="this.form.submit()" style="display: none;">
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
            <div>
                <form class="add-edit-book-form form-details" method="post" action="index.php?action=addEditBook" enctype="multipart/form-data">

                    <?php if ($book): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                    <div>
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" value="<?= $title ?>" required>
                    </div>
                    <div>
                        <label for="author">Auteur</label>
                        <input type="text" id="author" name="author" value="<?= $author ?>" required>
                    </div>
                    <div>
                        <label for="description">Description</label>
                        <textarea id="description" class="text-area" name="description" required><?= $description ?></textarea>
                    </div>
                    <?php if (!$book): ?>
                        <div>
                            <label for="fileToUpload" id="image" name="image">
                                Photo
                            </label>
                            <input
                                type="file"
                                id="fileToUpload"
                                name="fileToUpload"
                                accept="image/jpeg,image/png,image/gif"
                            >
                        </div>
                    <?php endif; ?> 
                    <div>
                        <label for="isAvailable">Disponible :</label>
                        <select id="isAvailable" name="isAvailable">
                            <option value="1" <?= $available
                                ? 'selected'
                                : '' ?>>Disponible</option>
                            <option value="0" <?= !$available
                                ? 'selected'
                                : '' ?>>Non dispo.</option>
                        </select>
                    </div>
                    <button type="submit" class="submit btn btn-form btn-primary"><?= isset($book)
                        ? 'Modifier'
                        : 'Ajouter' ?>
                    </button>
                </form>
            </div>
        </div>

    </section>
</div>