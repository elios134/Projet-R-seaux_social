<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body class="signup-page">
    <div class="container">
        <h2>Créer un compte</h2>

        <?php if (isset($error)): ?>
            <p style="color:red; text-align:center; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/inscription" method="POST" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="mail" placeholder="Email" required>

            <div class="field">
                <input type="password" name="password" placeholder="Mot de passe" required style="width:100%;">
                <button type="button" class="btn-toggle"><img src="../imgs/visibility-off.svg" alt="Masquer"></button>
            </div>

            <div class="field">
                <input type="password" name="password_confirm" placeholder="Confirmez le mot de passe" required style="width:100%;">
                <button type="button" class="btn-toggle"><img src="../imgs/visibility-off.svg" alt="Masquer"></button>
            </div>
            <div class="profile-upload">
                <div class="preview-container">
                    <img id="preview-avatar" src="default-avatar.png" alt="Aperçu" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                </div>
                <label for="avatar" style="margin-top:15px; display:block;">Photo de profil :</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" class="btn-add">S'inscrire</button>
        </form>
        <div class="footer-links" style="text-align:center; margin-top:20px;">
            <a href="/connexion">Déjà un compte ? Connectez-vous</a>
        </div>
    </div>
    <script src="../Js/script.js"></script>
</body>

</html>