<?php
$pageTitle = "Article List";
$cssFile = "/~93947770/cms/project/public/css/article_list.css";
include "src/views/header.php";
?>

<div id="header-bar">
    <div id="create-article-wrapper">
        <button id="create-article">Create Article</button>
        <div id="create-article-dialog" style="display:none;">
            <form id="create-article-form">
                <label for="new-article-name">Name:</label>
                <input type="text" id="new-article-name" name="name" required maxlength="32" autocomplete="off">
                <button type="submit" id="create-article-btn" disabled>Create</button>
                <button type="button" id="cancel-create-article">Cancel</button>
            </form>
        </div>
    </div>
    <div id="paginationControls">
        <button id="prevPage" style="display:none;">Previous</button>
        <span id="totalPages"></span>
        <button id="nextPage" style="display:none;">Next</button>
    </div>
</div>

<h2>Article List</h2>

<label for="tag-select">Tag: </label>
<select id="tag-select">
    <option value="">All</option>
    <?php foreach ($tags as $tag): ?>
        <option value="<?php echo $tag; ?>" <?php if ($tag === $selectedTag)
               echo 'selected'; ?>>
            <?php echo $tag; ?>
        </option>
    <?php endforeach; ?>
</select>


<ul id="articlesList"></ul>

<script>
    var articles = <?php echo json_encode($articles); ?>;
</script>
<script src="/~93947770/cms/project/public/js/article_list.js"></script>



<?php
include "src/views/footer.php";
?>