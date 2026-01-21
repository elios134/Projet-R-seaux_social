<?php
// On définit la fonction de rendu au tout début du fichier pour qu'elle soit chargée une seule fois
function renderComments($parentId, $commentsByParent, $postId) {
    if (!isset($commentsByParent[$parentId])) return;

    foreach ($commentsByParent[$parentId] as $comment) {
        // Définition de la marge pour les réponses
        $margin = ($parentId == 0) ? 0 : 30;
        ?>
        <div class="comment-item" style="margin-left: <?= $margin ?>px; <?= ($parentId != 0) ? 'border-left: 1px solid #ccc; padding-left: 10px; margin-top: 10px;' : '' ?>">
            <img src="/uploads/profiles/<?= $comment['image'] ?? 'default-profile.png' ?>" class="avatar-sm">

            <div class="comment-content">
                <div class="comment-bubble">
                    <strong><?= htmlspecialchars($comment['prenom']) ?></strong>
                    <p><?= htmlspecialchars($comment['content']) ?></p>
                </div>

                <div class="comment-utility" style="margin-left: 10px; margin-top: 4px;">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('reply-form-<?= $comment['id'] ?>').style.display = 'block';">Répondre</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $comment['id_user']): ?>
                        <a href="editcomment?id=<?= $comment['id'] ?>" class="btn-edit">Modifier</a>
                        <a href="deletecomment?id=<?= $comment['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer ce commentaire ?')">Supprimer</a>
                    <?php endif; ?>
                </div>

                <div id="reply-form-<?= $comment['id'] ?>" style="display:none; margin-top:10px;">
                    <form action="addcomment?id=<?= $postId ?>" method="POST" class="comment-form">
                        <input type="text" name="content" placeholder="Répondre à <?= htmlspecialchars($comment['prenom']) ?>..." required>
                        <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                        <button type="submit">Envoyer</button>
                    </form>
                </div>

                <?php 
                // Appel récursif pour afficher les réponses de ce commentaire
                renderComments($comment['id'], $commentsByParent, $postId); 
                ?>
            </div>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Mini Réseau Social</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="header-content">
        <h1>Mini-RS</h1>
        <nav>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="user-pill">
                    <a href="profil" title="Modifier mon profil">
                        <img src="/uploads/profiles/<?= $_SESSION['user']['image'] ?>" class="avatar-lg">
                    </a>
                    <span><strong><?= $_SESSION['user']['prenom'] ?></strong></span>
                    <a href="deconnexion" class="logout-link">Déconnexion</a>
                </div>
            <?php else: ?>
                <a href="connexion">Connexion</a>
                <a href="inscription">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['user'])): ?>
            <section class="publish-box">
                <h2>Quoi de neuf ?</h2>
                <form action="/" method="POST">
                    <input type="text" name="title" placeholder="Titre de votre post" required>
                    <textarea name="content" rows="4" placeholder="Exprimez-vous..." required></textarea>
                    <button type="submit" name="submit_post">Publier</button>
                </form>
            </section>
        <?php else: ?>
            <div class="info-card">
                <p><em>Connectez-vous pour partager vos pensées avec le monde.</em></p>
            </div>
        <?php endif; ?>

        <section id="feed">
            <h2>Fil d'actualité</h2>
            <?php if (empty($posts)): ?>
                <p class="text-muted">Aucun post pour le moment...</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">

                        <div class="post-header">
                            <img src="/uploads/profiles/<?= $post['user_image'] ?? 'default-profile.png' ?>"
                                alt="Avatar" class="avatar-md">

                            <div class="post-meta">
                                <h3><?= htmlspecialchars($post['title']) ?></h3>
                                <small>Par <?= htmlspecialchars($post['prenom']) ?></small>
                            </div>
                        </div>

                        <div class="post-body">
                            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                        </div>

                        <div class="post-actions">
                            <a href="/like?id=<?= $post['id'] ?>" class="like-link">
                                ❤️ <?= $post['count_likes'] ?? 0 ?> J'aime
                            </a>
                        </div>

                        <div class="comments-section">
                            <h4>Commentaires</h4>

                            <div class="comments-list">
                                <?php if (!empty($post['comments'])): ?>
                                    <?php
                                    // Organisation des commentaires par parent pour ce post précis
                                    $commentsByParent = [];
                                    foreach ($post['comments'] as $c) {
                                        $parentId = $c['parent_id'] ?? 0;
                                        $commentsByParent[$parentId][] = $c;
                                    }

                                    // Appel de la fonction définie au début du fichier
                                    renderComments(0, $commentsByParent, $post['id']);
                                    ?>
                                <?php endif; ?>
                            </div>

                            <?php if (isset($_SESSION['user'])): ?>
                                <form action="addcomment?id=<?= $post['id'] ?>" method="POST" class="comment-form">
                                    <input type="text" name="content" placeholder="Écrire un commentaire..." required>
                                    <button type="submit">Envoyer</button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <div class="post-footer">
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['id_user']): ?>
                                <div class="actions">
                                    <a href="editpost?id=<?= $post['id'] ?>" class="btn-edit">Modifier</a>
                                    <a href="deletepost?id=<?= $post['id'] ?>"
                                        class="btn-delete"
                                        onclick="return confirm('Supprimer définitivement ?')">
                                        Supprimer
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </div>
</body>
<script src="../Js/script.js"></script>

</html>