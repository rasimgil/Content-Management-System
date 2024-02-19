<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>
        <?php echo $pageTitle; ?>
    </title>
    <?php if (isset($cssFile)): ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>">
    <?php else: ?>
        <link rel="stylesheet" href="/~93947770/cms/project/public/css/styles.css">
    <?php endif; ?>
</head>

<body>
    <header>
    </header>
    <main>