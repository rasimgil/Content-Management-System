<?php
$pageTitle = "Edit Article";
$cssFile = "/~93947770/cms/project/public/css/article_edit.css";
include __DIR__ . "/header.php";
?>
<div class="edit-article-form">
    <form id="edit-article-form" action="/article-edit/<?php echo $article['id']; ?>" method="POST">
        <label for="article-name">Name:</label>
        <input type="text" id="article-name" name="name"
            value="<?php echo htmlspecialchars($article['name'], ENT_QUOTES); ?>" required maxlength="32"
            autocomplete="off">
        <label for="article-tags">Tags:</label>
        <input type="text" id="article-tags" name="tags"
            value="<?php echo htmlspecialchars($tagsString, ENT_QUOTES); ?>">
        <label for="article-content">Content:</label>
        <textarea id="article-content" name="content"
            maxlength="1024"><?php echo htmlspecialchars($article['content'], ENT_QUOTES); ?></textarea>
    </form>
</div>
<div class="actions">
    <button type="submit" form="edit-article-form" id="save-article-btn">Save</button>
    <a href="../articles" class="back-link">Back to Articles</a>
</div>
<script src="/~93947770/cms/project/public/js/article_edit.js"></script>
<?php include __DIR__ . "/footer.php"; ?>