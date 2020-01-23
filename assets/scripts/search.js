const searchForm = document.querySelector(".search__form");
const postContainerSearch = document.querySelector(".post__container");

searchForm.addEventListener("input", e => {
    e.preventDefault();
    const formData = new FormData(searchForm);
    fetch("/app/posts/search.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(posts => {
            postContainerSearch.innerHTML = "";
            createAndAppendPosts(posts);
        });
});
