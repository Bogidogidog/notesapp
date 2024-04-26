<?php
include 'partials/header.php';

// Überprüfe, ob die Sucheingabe vorhanden ist
if(isset($_GET['search']) && isset($_GET['submit'])){
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Verwende Prepared Statements, um SQL-Injection zu verhindern
    $query = "SELECT * FROM notes WHERE title LIKE ? OR description LIKE ? ORDER BY date_time DESC";
    $stmt = $connection->prepare($query);
    // Das Prozentzeichen (%) muss dem Suchbegriff vor und nach dem Binden hinzugefügt werden
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
    $stmt->execute();
    $notes = $stmt->get_result();
} else {
    // Wenn keine Sucheingabe vorhanden ist, leite zurück zur Startseite
    header("Location: " . ROOT_URL . "index.php");
    exit();
}
?>

<?php if(mysqli_num_rows($notes) > 0) : ?>
<section class="notes section__extra-margin">
    <div class="container notes__container">
        <?php while ($note = mysqli_fetch_assoc($notes)) : ?>
        <article class="note">
            <div class="note__info">
                <h2 class="note__title"><a
                        href="<?= ROOT_URL ?>note.php?id=<?= $note['id'] ?>"><?= $note['title'] ?></a></h2>
                <a href="<?= ROOT_URL ?>note.php?id=<?= $note['id'] ?>">
                    <p class="note__description" style="min-height: 100px;">
                        <?= substr($note['description'], 0, 150) ?>
                    </p>
                </a>
                <h6 class="note__title"><?= $note['date_time'] ?></h6>
            </div>
        </article>
        <?php endwhile ?>
    </div>
</section>
<?php else : ?>
<div class="alert__message error lg section__extra-margin">
    <p>No note found for this search</p>
</div>
<?php endif ?>

<?php
include 'partials/footer.php';
?>