<?php
$pageTitle = "Article Detail";
$cssFile = "/~93947770/cms/project/public/css/article_detail.css";
include "src/views/header.php";
?>
<div class="article-header">
    <h2>
        <?php echo $article["name"]; ?>
    </h2>
    <h3>
        <?php foreach ($tags as $tag): ?>
            <span class="badge rounded-pill bg-secondary">
                <?php echo $tag; ?>
            </span>
        <?php endforeach; ?>
    </h3>
</div>
</div>
<div class="article-content">
    <p>
        <?php echo $article["content"]; ?>
    </p>
</div>
<div class="actions">
    <a href="../article-edit/<?php echo $article['id']; ?>" class="edit-link">Edit</a>
    <a href="../articles" class="back-link">Back to Articles</a>
</div>
<?php include "src/views/footer.php"; ?>