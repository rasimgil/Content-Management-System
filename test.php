<?php
require_once 'src/Model.php';

$model = new Model([
    'server'   => '',
    'login'    => '',
    'password' => '',
    'database' => '',
]);

echo "connected ";
for ($i = 1; $i <= 24; $i++) {
    $name = "Article $i";
    $content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tempor in odio id tincidunt. Maecenas ut porttitor sapien. Nam congue turpis nec magna euismod pretium. Vivamus commodo felis lorem. Morbi porta vitae turpis et accumsan. Integer quis leo sed velit porttitor aliquet eget at orci. Suspendisse nulla nisi, rhoncus commodo aliquam sit amet, pharetra quis quam. Integer sit amet ornare odio, at varius ligula. Vestibulum condimentum viverra erat euismod accumsan. In gravida ut nibh sit amet mollis. Integer augue nisi, luctus a ipsum porttitor, dapibus tincidunt ipsum. Nunc nec dui quam.";
    $model->createArticle($name, $content);
}

echo "test";

$model->closeConnection();
