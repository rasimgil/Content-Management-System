<?php

class Model
{
    private $db;

    public function __construct($dbConfig)
    {
        $this->db = new mysqli(
            $dbConfig["server"],
            $dbConfig["login"],
            $dbConfig["password"],
            $dbConfig["database"]
        );
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getAllArticles()
    {
        $query = "SELECT * FROM articles";
        $result = $this->db->query($query);
        $articles = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }

    public function getArticleById($id)
    {
        $id = (int) $id;
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createArticle($name, $content)
    {
        $stmt = $this->db->prepare("INSERT INTO articles (name, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $content);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function updateArticle($id, $name, $content)
    {
        $id = (int) $id;
        $stmt = $this->db->prepare("UPDATE articles SET name = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $content, $id);
        return $stmt->execute();
    }

    public function deleteArticle($id)
    {
        $id = (int) $id;
        $this->removeTagsFromArticle($id);
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    public function getTagsByArticleId($articleId)
    {
        $articleId = (int) $articleId;
        $query = "SELECT name FROM article_tags WHERE article_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = $row['name'];
        }
        return $tags;
    }

    public function addTagsToArticle($articleId, $tags)
    {
        $articleId = (int) $articleId;
        $query = "INSERT INTO article_tags (name, article_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        foreach ($tags as $tag) {
            $stmt->bind_param("si", $tag, $articleId);
            $stmt->execute();
        }
    }

    public function removeTagsFromArticle($articleId)
    {
        $articleId = (int) $articleId;
        $query = "DELETE FROM article_tags WHERE article_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
    }

    public function getArticlesByTag($tag)
    {
        $query = "SELECT a.* FROM articles a 
                  INNER JOIN article_tags at ON a.id = at.article_id
                  WHERE at.name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $tag);
        $stmt->execute();
        $result = $stmt->get_result();
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
        return $articles;
    }

    public function getAllTags()
    {
        $query = "SELECT DISTINCT name FROM article_tags";
        $result = $this->db->query($query);
        $tags = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $tags[] = $row["name"];
            }
        }
        return $tags;
    }

    public function closeConnection()
    {
        $this->db->close();
    }
}

