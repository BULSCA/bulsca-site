document.querySelectorAll("[data-tag-input]").forEach((tagInput) => {
    const hiddenInput = tagInput.querySelector("input");
    const input = tagInput.querySelector("div[contenteditable].fake-input");
    const tags = tagInput.querySelector("div.tags");
    const suggestedList = tagInput.querySelector(".suggested");
    const allowNew = tagInput.getAttribute("data-tag-allow-new") === "true";

    let suggested = [];

    fetch("/admin/sercs/serc-tags")
        .then((response) => response.json())
        .then((tags) => {
            suggested = tags;
        });

    tagInput.onclick = () => {
        input.focus();
    };

    function addTag(name) {
        const tag = document.createElement("span");
        tag.textContent = name.trim();
        tags.appendChild(tag);

        hiddenInput.value = Array.from(tags.children)
            .map((tag) => tag.textContent)
            .join(",");

        suggestedList.style.display = "none";

        tag.onclick = () => {
            tag.remove();

            hiddenInput.value = Array.from(tags.children)
                .map((tag) => tag.textContent)
                .filter((tag) => tag !== name)
                .join(",");
        };
    }

    var targetedSuggestion = null;

    input.onkeydown = (e) => {
        if (e.key === "Enter") {
            e.preventDefault();

            if (targetedSuggestion) {
                addTag(targetedSuggestion.textContent);
                targetedSuggestion.remove();
                targetedSuggestion = null;
                input.textContent = "";
                return;
            }

            if (!allowNew) {
                return;
            }

            if (input.textContent.trim() === "") {
                return;
            }

            input.textContent.split(",").forEach((tag) => {
                addTag(tag);
            });

            input.textContent = "";
        }

        if (e.key === "ArrowDown") {
            if (targetedSuggestion) {
                targetedSuggestion.style.backgroundColor = "white";
                targetedSuggestion = targetedSuggestion.nextElementSibling;
            } else {
                targetedSuggestion = suggestedList.firstElementChild;
            }

            if (targetedSuggestion) {
                targetedSuggestion.style.backgroundColor = "lightgray";
            }
        }

        if (e.key === "ArrowUp") {
            if (targetedSuggestion) {
                targetedSuggestion.style.backgroundColor = "white";
                targetedSuggestion = targetedSuggestion.previousElementSibling;
            } else {
                targetedSuggestion = suggestedList.lastElementChild;
            }

            if (targetedSuggestion) {
                targetedSuggestion.style.backgroundColor = "lightgray";
            }
        }
    };

    input.onkeyup = (e) => {
        if (e.key === "ArrowDown" || e.key === "ArrowUp" || e.key === "Enter") {
            return;
        }

        if (e.key === "Escape") {
            suggestedList.style.display = "none";
            input.textContent = "";
            input.blur();
            return;
        }

        let similar = searchSimilar(input.textContent.trim());

        suggestedList.innerHTML = "";
        similar.forEach((tag) => {
            const suggested = document.createElement("span");
            suggested.textContent = tag;
            suggested.onclick = (e) => {
                e.preventDefault();
                addTag(tag);
                suggested.remove();
                input.textContent = "";
            };
            suggestedList.appendChild(suggested);
        });

        if (similar.length) {
            suggestedList.style.display = "flex";
        } else {
            suggestedList.style.display = "none";
        }
    };

    input.onblur = () => {
        setTimeout(() => {
            suggestedList.style.display = "none";
        }, 100);
    };

    tagInput
        .getAttribute("data-tag-default-value")
        .split(",")
        .forEach((tag) => {
            if (tag.trim() === "") {
                return;
            }
            addTag(tag);
        });

    function searchSimilar(name) {
        let all = suggested.filter((tag) =>
            tag.toLowerCase().includes(name.toLowerCase())
        );

        let limit = 6;

        let desired = [];

        for (let i = 0; i < all.length; i++) {
            if (desired.length === limit) {
                break;
            }

            if (all[i] === "") continue;

            desired.push(all[i]);
        }

        return desired;
    }
});
