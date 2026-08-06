<?php
/**
 * Add or edit book template.
 */
/** @var object $book */
?>

<div class="page-container">
    <div class="add-edit-book-page">
        <h1><?= isset($book) ? 'Modifier le livre' : 'Ajouter un livre' ?></h1>
        <form method="post" action="index.php?action=addEditBookPost" enctype="multipart/form-data">
            <?php if (!empty($book->getId())): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($book->getId()) ?>">
            <?php endif; ?>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="<?= isset($book)
                ? htmlspecialchars($book->getTitle())
                : '' ?>" required>

            <label for="author">Auteur :</label>
            <input type="text" id="author" name="author" value="<?= isset($book)
                ? htmlspecialchars($book->getAuthor())
                : '' ?>" required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required><?= isset($book)
                ? htmlspecialchars($book->getDescription())
                : '' ?></textarea>

            <label for="image">Image :</label>
            <input type="file" id="image" name="image" <?= isset($book) ? '' : 'required' ?>>

            <label for="isAvailable">Disponible :</label>
            <select id="isAvailable" name="isAvailable">
                <option value="" disabled selected>-- Choisissez une option --</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
            <button type="submit"><?= isset($book) ? 'Modifier' : 'Ajouter' ?></button>
        </form>
    </div>