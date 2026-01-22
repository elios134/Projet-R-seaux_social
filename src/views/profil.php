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
                <div class="msg-success"><?= htmlspecialchars($_GET['msg']) ?></div>
            <?php endif; ?>
            
            <img src="/uploads/profiles/<?= $_SESSION['user']->getImage() ?>" class="avatar-lg" alt="Avatar">
            <p>
                <strong><?= htmlspecialchars($_SESSION['user']->getPrenom() . ' ' . $_SESSION['user']->getNom()) ?></strong>
            </p>
        </div>
    </header>

    <div class="container">
        <form action="/profil" method="POST" enctype="multipart/form-data" class="upload-form">
            <div class="profile-upload">
                <div class="preview-container">
                    <img id="preview-avatar" src="/uploads/profiles/<?= $_SESSION['user']->getImage() ?>" alt="Aperçu" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                </div>
                <label for="avatar" style="margin-top:15px; display:block;">Changer ma photo de profil :</label>
                <input type="file" name="avatar" id="avatar" accept="image/*" required>
                <button type="submit" class="btn-primary">Mettre à jour la photo</button>
            </div>
        </form>

        <section class="user-info">
            <h3>Informations personnelles</h3>
            <ul>
                <li><strong>Email :</strong> <?= htmlspecialchars($_SESSION['user']->getMail()) ?></li>
                <li><strong>Rôle :</strong> <?= htmlspecialchars($_SESSION['user']->getRole()) ?></li>
            </ul>
        </section>
    </div>

</body>
<script src="../Js/script.js"></script>
</html>