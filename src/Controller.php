<?php
class Controller
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function route($url)
    {
        $basePath = "/~93947770/cms/project/";
        $url = str_replace($basePath, "", $url);
        $url = trim($url, "/");
        if ($url === "") {
            $action = 'articles';
        } else {
            $parts = explode("/", $url);
            $action = $parts[0];
            $articleId = isset($parts[1]) ? $parts[1] : null;
        }
        switch ($action) {
            case "articles":
                $this->handleArticleList();
                break;
            case "article":
                $this->handleArticleDetail($articleId);
                break;
            case "article-edit":
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $this->handleArticleUpdate($articleId);
                } else {
                    $this->handleArticleEdit($articleId);
                }
                break;
            case "delete-article":
                $this->handleArticleDelete($articleId);
                break;
            case "create-article":
                $this->handleArticleCreate();
                break;
            default:
                $this->handleNotFound();
                break;
        }
    }

    private function handleArticleList()
    {
        $tags = $this->model->getAllTags();
        $selectedTag = isset($_GET['tag']) ? $_GET['tag'] : null;
        if ($selectedTag) {
            $articles = $this->model->getArticlesByTag($selectedTag);
        } else {
            $articles = $this->model->getAllArticles();
        }

        foreach ($articles as &$article) {
            $article['name'] = htmlspecialchars($article['name']);
        }
        unset($article);

        include __DIR__ . '/views/article_list.php';
    }



    private function handleArticleDetail($articleId)
    {
        $article = $this->model->getArticleById($articleId);
        $tags = $this->model->getTagsByArticleId($articleId);
        if ($article) {
            $article['name'] = htmlspecialchars($article['name']);
            $article['content'] = htmlspecialchars($article['content']);
            include __DIR__ . '/views/article_detail.php';
        } else {
            $this->handleNotFound();
        }
    }


    private function handleArticleEdit($articleId)
    {
        $article = $this->model->getArticleById($articleId);
        $tags = $this->model->getTagsByArticleId($articleId);
        $tagsString = implode(' ', $tags);
        $article['content'] = htmlspecialchars_decode($article['content']);
        $article['name'] = htmlspecialchars_decode($article['name']);
        if ($article) {
            include __DIR__ . '/views/article_edit.php';
        } else {
            $this->handleNotFound();
        }
    }

    private function handleArticleDelete($articleId)
    {
        if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
            header("Content-Type: application/json");
            $result = $this->model->deleteArticle($articleId);
            if ($result) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false]);
            }
        } else {
            echo json_encode(["error" => false]);
            http_response_code(405);
        }
        exit;
    }

    private function handleArticleCreate()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $articleId = $this->model->createArticle($data['name'], "");
        if ($articleId) {
            $this->model->addTagsToArticle($articleId, $data["tags"]);
            echo json_encode(['success' => true, 'articleId' => $articleId]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }



    private function handleArticleUpdate($articleId)
    {
        $name = $_POST["name"] ?? "";
        $content = $_POST["content"] ?? "";
        $tags = isset($_POST["tags"]) ? preg_split('/\s+/', $_POST["tags"]) : [];
        if ($this->model->updateArticle($articleId, $name, $content)) {
            $this->model->removeTagsFromArticle($articleId);
            $this->model->addTagsToArticle($articleId, $tags);
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false]);
            http_response_code(500);
            exit;
        }
    }

    private function handleNotFound()
    {
        include __DIR__ . '/views/fof.php';
    }
}