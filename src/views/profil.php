<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="profile-page">
    <header>
        <a href="/" class="btn-back">← Retour au fil d'actualité</a>

        <div class="profile-card">
            <h2>Mon Profil</h2>
            <?php if (isset($_GET['msg'])): ?>
                <div class="msg-success"><?= ($_GET['msg']) ?></div>
            <?php endif; ?>
            <img src="/uploads/profiles/<?= $_SESSION['user']['image'] ?>" class="avatar-lg">
            <p>
                <strong><?= ($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></strong>
            </p>
        </div>
    </header>

    <div class="container">
        <form action="/profil" method="POST" enctype="multipart/form-data" class="upload-form">
            <div class="profile-upload">
                <div class="preview-container">
                    <img id="preview-avatar" src="default-avatar.png" alt="Aperçu" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                </div>
                <label for="avatar" style="margin-top:15px; display:block;">Photo de profil :</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <br>
            <button type="submit" class="btn-add">Enregistrer les modifications</button>
        </form>

    </div>
</body>
<script src="../Js/script.js"></script>
</html>