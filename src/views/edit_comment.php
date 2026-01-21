<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le commentaire</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>Modifier votre commentaire</h1>
        <nav><a href="/">Retour à l'accueil</a></nav>
    </header>
    <div class="container">
        <section>
            <form action="/edit-comment?id=<?= $comment['id'] ?>" method="POST">
                <textarea name="content" rows="5" required><?= htmlspecialchars($comment['content']) ?></textarea>
                <button type="submit">Enregistrer les modifications</button>
            </form>
        </section>
    </div>
</body>

</html>