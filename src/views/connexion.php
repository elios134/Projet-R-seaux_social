<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body class="login-page">
    <div class="container">
        <h2>Connexion</h2>

        <?php if (isset($_GET['error'])): ?>
            <p style="color:red; text-align:center; font-weight:bold;">Email ou mot de passe incorrect.</p>
        <?php endif; ?>

        <?php if (isset($_GET['msg'])): ?>
            <p style="color:green; text-align:center;"><?= htmlspecialchars($_GET['msg']) ?></p>
        <?php endif; ?>

        <form action="/connexion" method="post">
            <input type="email" name="login_mail" placeholder="Email" required>

            <div class="field" style="position:relative; display:flex; align-items:center; margin-top:10px;">
                <input type="password" name="login_pass" placeholder="Mot de passe" required style="width:100%;">
                <button type="button" class="btn-toggle" ><img src="../imgs/visibility-off.svg" alt="Masquer"></button>
            </div>

            <button type="submit" name="connexion" class="btn btn-edit" s>Se connecter</button>
        </form>
        <div class="footer-links" style="text-align:center; margin-top:20px;">
            Nouveau ici ? <a href="/inscription">Créer un compte</a>
        </div>
    </div>
    <script src="../Js/script.js"></script>
</body>

</html>