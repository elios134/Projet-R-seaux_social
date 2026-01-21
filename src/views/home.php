<?php include __DIR__ . '/partials/comment.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Mini Réseau Social</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <header>
    <h1>Mini-RS</h1>
    <nav>
        <?php if (isset($_SESSION['user'])) : ?>
            <!-- Pill utilisateur avec avatar et prénom -->
            <a href="/profil" class="user-pill">
                <img src="/uploads/profiles/<?= $_SESSION['user']['image'] ?>" class="avatar-lg" alt="Avatar">
                <span><?= $_SESSION['user']['prenom'] ?></span>
            </a>
            
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="/admin-users" class="btn-admin">Gérer Utilisateurs</a>
            <?php endif; ?>
            
            <a href="/deconnexion" class="btn-danger">Déconnexion</a>
            
        <?php else : ?>
            <a href="/connexion">Connexion</a>
            <a href="/inscription" class="btn-primary">Inscription</a>
        <?php endif; ?>
    </nav>
</header>

    <div class="container">
        <?php if (isset($_SESSION['user'])): ?>
            <section class="publish-box">
                <h2>Quoi de neuf ?</h2>
                <form action="/addpost" method="POST"> <input type="text" name="title" placeholder="Titre de votre post" required>
                    <textarea name="content" rows="4" placeholder="Exprimez-vous..." required></textarea>
                    <button type="submit" name="submit_post">Publier</button>
                </form>
            </section>
        <?php else: ?>
            <div class="info-card">
                <p><em>Connectez-vous pour partager vos pensées avec le monde.</em></p>
            </div>
        <?php endif; ?>

        <section class="posts">
            <?php if (empty($posts)) : ?>
                <p>Aucun post pour le moment.</p>
            <?php else : ?>
                <?php foreach ($posts as $post) : ?>
                    <article class="post-card">

                        <div class="post-header">
                            <img src="/uploads/profiles/<?= $post['user_image'] ?>" class="avatar-md">
                            <div class="post-info">
                                <h3><?= htmlspecialchars($post['prenom']) ?></h3>
                                <h2><?= htmlspecialchars($post['title']) ?></h2>
                            </div>
                        </div>

                        <div class="post-body">
                            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                        </div>

                        <div class="post-actions">
                            <a href="like?id=<?= $post['id'] ?>" class="btn-like">
                                ❤️ <?= $post['count_likes'] ?? 0 ?> J'aime
                            </a>
                        </div>

                        <div class="comments-section">
                            <h4>Commentaires</h4>
                            <?php
                            $commentsByParent = [];
                            if (!empty($post['comments'])) {
                                foreach ($post['comments'] as $comment) {
                                    $parentId = $comment['parent_id'] ?? 0;
                                    $commentsByParent[$parentId][] = $comment;
                                }
                            }
                            renderComments(0, $commentsByParent, $post['id']);
                            ?>

                            <?php if (isset($_SESSION['user'])) : ?>
                                <form action="addcomment?id=<?= $post['id'] ?>" method="POST" class="comment-form">
                                    <input type="text" name="content" placeholder="Écrire un commentaire..." required>
                                    <button type="submit">Envoyer</button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <div class="post-footer">
                            <?php
                            $isOwner = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['id_user']);
                            $isAdminOrModo = (isset($_SESSION['user']) && ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'modo'));

                            if ($isOwner || $isAdminOrModo):
                            ?>
                                <div class="actions">
                                    <?php if ($isOwner): ?>
                                        <a href="editpost?id=<?= $post['id'] ?>" class="btn-edit">Modifier</a>
                                    <?php endif; ?>

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
    <script src="../Js/script.js"></script>
</body>

</html>