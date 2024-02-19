let currentPage = 1;
let articlesPerPage = 10;

const displayArticlesForPage = (page) => {
    const startIndex = (page - 1) * articlesPerPage;
    const endIndex = Math.min(startIndex + articlesPerPage, articles.length);
    const articlesList = document.querySelector("#articlesList");
    articlesList.innerHTML = "";

    for (let i = startIndex; i < endIndex; i++) {
        const article = articles[i];
        const li = document.createElement("li");
        li.innerHTML = `
            <div class="article-tab">
                <h3>${article.name}</h3>
                <div class="actions">
                    <a href="/~93947770/cms/project/article/${article.id}" title="Show">󰊪</a>
                    <a href="/~93947770/cms/project/article-edit/${article.id}" title="Edit"></a>
                    <a href="#" class="delete-article" data-id="${article.id}" title="Delete"></a>
                </div>
            </div>
        `;
        articlesList.appendChild(li);
    }

    updatePaginationControls();
};

const updatePaginationControls = () => {
    const totalPages = Math.ceil(articles.length / articlesPerPage);
    document.getElementById(
        "totalPages"
    ).textContent = `${currentPage} / ${totalPages}`;
    document.getElementById("prevPage").style.display =
        currentPage > 1 ? "inline-block" : "none";
    document.getElementById("nextPage").style.display =
        currentPage * articlesPerPage < articles.length
            ? "inline-block"
            : "none";
};

document.addEventListener("DOMContentLoaded", () => {
    displayArticlesForPage(currentPage);
});

document.getElementById("nextPage").addEventListener("click", () => {
    if (currentPage * articlesPerPage < articles.length) {
        currentPage++;
        displayArticlesForPage(currentPage);
    }
});

document.getElementById("prevPage").addEventListener("click", () => {
    if (currentPage > 1) {
        currentPage--;
        displayArticlesForPage(currentPage);
    }
});

document.addEventListener("click", (e) => {
    if (e.target.classList.contains("delete-article")) {
        e.preventDefault();
        const articleId = e.target.getAttribute("data-id");

        fetch(`/~93947770/cms/project/delete-article/${articleId}`, {
            method: "DELETE",
        })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("Network response was not ok.");
            })
            .then((data) => {
                if (data.success) {
                    console.log("Article deleted successfully");
                    articles = articles.filter(
                        (article) => article.id.toString() !== articleId
                    );
                    if (
                        !articles.slice(
                            (currentPage - 1) * articlesPerPage,
                            currentPage * articlesPerPage
                        ).length &&
                        currentPage > 1
                    ) {
                        currentPage--;
                    }
                    displayArticlesForPage(currentPage);
                }
            })
            .catch((error) => {
                console.error(
                    "There has been a problem with your fetch operation:",
                    error
                );
            });
    }
});

document.getElementById("create-article").addEventListener("click", () => {
    document.getElementById("create-article-dialog").style.display = "block";
});

document
    .getElementById("cancel-create-article")
    .addEventListener("click", () => {
        document.getElementById("create-article-dialog").style.display = "none";
    });

document
    .getElementById("new-article-name")
    .addEventListener("input", function () {
        const createButton = document.getElementById("create-article-btn");
        const inputValue = this.value;
        const notificationId = "create-article-notification";
        let notificationElement = document.getElementById(notificationId);

        createButton.disabled = !inputValue.trim();

        if (!inputValue.trim() && !notificationElement) {
            notificationElement = document.createElement("div");
            notificationElement.id = notificationId;
            notificationElement.textContent =
                "Name is required to create the article.";
            notificationElement.style.color = "red";
            notificationElement.style.marginTop = "10px";
            const form = document.getElementById("create-article-form");
            form.appendChild(notificationElement);
        } else if (inputValue.trim() && notificationElement) {
            notificationElement.remove();
        }
    });

document
    .getElementById("create-article-form")
    .addEventListener("submit", (e) => {
        e.preventDefault();
        const articleName = document.getElementById("new-article-name").value;
        if (!articleName.trim()) {
            alert("Name is required to create the article.");
            return;
        }
        fetch("/~93947770/cms/project/create-article", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ name: articleName, content: "" }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data);
                    window.location.href = `/~93947770/cms/project/article-edit/${data.articleId}`;
                } else {
                    alert("Failed to create the article.");
                }
            })
            .catch((error) => console.error("Error:", error));
    });

document.getElementById("create-article").addEventListener("click", () => {
    document.getElementById("create-article").style.display = "none";
    document.getElementById("create-article-dialog").style.display = "block";
});

document
    .getElementById("cancel-create-article")
    .addEventListener("click", () => {
        document.getElementById("create-article").style.display = "block";
        document.getElementById("create-article-dialog").style.display = "none";
    });

document.getElementById("tag-select").addEventListener("change", (e) => {
    const tag = e.target.value;
    const url = window.location.href.split("?")[0];
    const separator = url.indexOf("?") !== -1 ? "&" : "?";
    window.location.href = `${url}${separator}tag=${tag}`;
});
