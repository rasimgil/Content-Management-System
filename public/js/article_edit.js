const handleFormSubmission = () => {
    console.log("Form submission handler attached");
    const form = document.getElementById("edit-article-form");

    form.addEventListener("submit", (e) => {
        console.log("Form submitted");
        e.preventDefault();

        const articleId = form.action.split("/").pop();
        const formData = new FormData(form); 

        const apiUrl = `/~93947770/cms/project/article-edit/${articleId}`;

        fetch(apiUrl, {
            method: "POST",
            body: new URLSearchParams(formData),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    window.location.href = "/~93947770/cms/project/articles";
                } else {
                    console.error("oops");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
};


function validateFormInputs() {
    const nameInput = document.getElementById("article-name");
    const saveButton = document.getElementById("save-article-btn");
    const tagsInput = document.getElementById("article-tags");
    const isValidTag = (tag) => {
        return /^[a-zA-Z0-9]{1,32}$/.test(tag);
    };
    const validateForm = () => {
        const isNameEmpty = !nameInput.value.trim();
        const tags = tagsInput.value.split(/\s+/).map((tag) => tag.trim());
        const invalidTags = tags.some((tag) => {
            return tag.length === 0 || tag.length > 32 || !isValidTag(tag);
        });

        const noTags = tags.every((tag) => tag.length === 0);

        saveButton.disabled = isNameEmpty || (invalidTags && !noTags);

        let notificationElement = document.getElementById("notification");

        if (isNameEmpty) {
            if (!notificationElement) {
                notificationElement = document.createElement("div");
                notificationElement.id = "notification";
                notificationElement.textContent =
                    "Name is required to save the article.";
                notificationElement.style.color = "red";
                nameInput.parentNode.insertBefore(
                    notificationElement,
                    nameInput.nextSibling
                );
            }
        } else {
            if (notificationElement) {
                notificationElement.remove();
            }
        }
    };

    nameInput.addEventListener("input", validateForm);
    tagsInput.addEventListener("input", validateForm);

    validateForm();
}

document.addEventListener("DOMContentLoaded", () => {
    validateFormInputs();
    handleFormSubmission();
});
