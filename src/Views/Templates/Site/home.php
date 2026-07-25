<?php
    /**
     * Affichage de Liste des articles. 
     */

    /** @var App\Models\Book[] $books */
 
?>

<!-- About -->
<section class="home-container about">
    <div class="about-text">
      <h1>Rejoignez nos lecteurs passionnés</h1>
      <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. 
      Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
      </p>
      <button class="btn btn-primary">Découvrir</button>
    </div>
    <div class="about-img">
        <img src="/assets/images/homme-et-livres.jpg" alt="Image d'un homme avec des livres">
        <p class="caption">Hamza</p>
    </div>
</section>
<!-- List of the four last books add -->
 <section class="home-container last-added">
 <h2>Les derniers livres ajoutés</h2>
 <ul>
    <?php foreach ($books as $book): ?>
        <li>
            <a class="book-card">
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
                        <?= htmlspecialchars($book->getUser()->getUsername()) ?>
                    </span>
                </p>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
  <a href="index.php?action=books" class="btn btn-primary">Voir tous les livres</a>

 </section>
<!-- How it works -->
 <section class="home-container how-it-works">
    <h2>Comment ça marche ?</h2>
    <p>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
    <ul>
      <li>
        <p>
          Inscrivez-vous gratuitement sur notre plateforme.
        </p>
      </li>
      <li>
        <p>
          Ajoutez les livres que vous souhaitez échanger à votre profil.
        </p>
      </li>
      <li>
        <p>
          Parcourez les livres disponibles chez d'autres membres.
        </p>
      </li>
      <li>
        <p>
          Proposez un échange et discutez avec d'autres passionnés de lecture.
        </p>
      </li>
    </ul>
    <a href="index.php?action=books" class="btn btn-secondary">Voir tous les livres</a>
    
 </section>
 <img src="/assets/images/darwin-vegher.jpg" alt="image de livres">
<!-- Our values -->
 <section class="home-container our-values">
  <div class="values-box">
    <h2>Nos valeurs</h2>
    <div class="values-text">
        <p>
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. 
            Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. 
            Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
        </p>
        <p>
            Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. 
        </p>
        <p>
            Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, 
            de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
        </p>
    </div>
    <div class="signature">
      <p class="caption">
        L’équipe Tom Troc
      </p>
      <img src="/assets/images/Vector_2.png" alt="Signature en forme de coeur vert">
    </div>
  </div>
 </section>