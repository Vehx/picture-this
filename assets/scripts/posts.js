"use strict";

// in this file posts are fetched if any exsists and then made into post elements and placed in the dom post-container

//ändra postsReadUrl till search.php om d e sök
const postsReadUrl = "/app/posts/read.php";
const postsUpdateUrl = "/app/posts/update.php";
const postsDeleteUrl = "/app/posts/delete.php";

const createPostBtn = document.querySelector(".post__create-btn");
const cancelPostBtn = document.querySelector(".post__cancel-btn");
const postForm = document.querySelector(".post__form");

// function to delete post, after its posts to server it hides the post
const handleRemove = e => {
    let postId = e.srcElement.parentElement.parentElement.dataset.id;

    const formData = new FormData();
    formData.append("post-id", `${postId}`);

    fetch(postsDeleteUrl, {
        method: "post",
        body: formData
    });
    e.srcElement.parentElement.parentElement.classList.remove("d-flex");
    e.srcElement.parentElement.parentElement.classList.add("hidden");
};

createPostBtn.addEventListener("click", () => {
    // console.log("Creating post :)");
    createPostBtn.classList.add("hidden");
    cancelPostBtn.classList.remove("hidden");
    postForm.classList.remove("hidden");
});

cancelPostBtn.addEventListener("click", () => {
    // console.log("Canceling post making :(");
    createPostBtn.classList.remove("hidden");
    cancelPostBtn.classList.add("hidden");
    postForm.classList.add("hidden");
});

fetch(postsReadUrl)
    .then(response => response.json())
    .then(posts => {
        createAndAppendPosts(posts);
    });
