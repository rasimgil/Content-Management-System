<?php
$pageTitle = "404 Not Found";
$cssFile = "/public/css/fof.css";
include __DIR__ . "/header.php";
?>

<main>
    <div class="not-found">
        <h1>404 Not Found</h1>
        <p>The article you are looking for does not exist or has been removed.</p>
        <a href="/articles">Back to Articles</a>
    </div>
</main>

<?php
include __DIR__ . "/footer.php";
?>