<?php
function renderComments($parentId, $commentsByParent, $postId)
{
    if (!isset($commentsByParent[$parentId])) return;

    foreach ($commentsByParent[$parentId] as $comment) {
        $margin = ($parentId == 0) ? 0 : 30;
?>
        <div class="comment-item">
            <img src="/uploads/profiles/<?= $comment['image'] ?? 'default-profile.png' ?>" class="avatar-sm">

            <div class="comment-content">
                <div class="comment-bubble">
                    <strong><?= $comment['prenom'] ?></strong>
                    <p><?= $comment['content'] ?></p>
                </div>

                <div class="comment-utility" >
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('reply-form-<?= $comment['id'] ?>').style.display='block';">Répondre</a>
                    <?php endif; ?>

                    <?php
                    $isCommentOwner = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $comment['id_user']);
                    $isAdminOrModo = (isset($_SESSION['user']) && ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'modo'));

                    if ($isCommentOwner || $isAdminOrModo) : ?>
                        <?php if ($isCommentOwner) : ?>
                            <a href ="edit-comment?id=<?= $comment['id'] ?>">Modifier</a>
                        <?php endif; ?>
                        <a href="deletecomment?id=<?= $comment['id'] ?>" style="color:red;" onclick="return confirm('Supprimer ce commentaire ?')">Supprimer</a>
                    <?php endif; ?>
                </div>

                <form id="reply-form-<?= $comment['id'] ?>" action="addcomment?id=<?= $postId ?>" method="POST" style="display:none; margin-top:10px;">
                    <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                    <input type="text" name="content" placeholder="Répondre à ce commentaire..." required>
                    <button type="submit">Envoyer</button>
                    <button type="button" onclick="document.getElementById('reply-form-<?= $comment['id'] ?>').style.display = 'none';">Annuler</button>
                </form>

                <?php renderComments($comment['id'], $commentsByParent, $postId); ?>
            </div>
        </div>
<?php
    }
}
?>