<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le Post</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>Modifier votre post</h1>
        <nav><a href="/">Retour à l'accueil</a></nav>
    </header>
    <div class="container">
        <form action="/edit-post?id=<?= $post['id'] ?>" method="POST">
            <input type="text" name="title" value="<?= $post['title'] ?>" required><br>
            <textarea name="content" required><?= $post['content'] ?></textarea><br>
            <button type="submit" name="update_post">Enregistrer les modifications</button>
            <a href="/">Annuler</a>
        </form>
    </div>
</body>

</html>