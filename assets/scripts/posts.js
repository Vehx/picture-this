"use strict";

// in this file posts are fetched if any exsists and then made into post elements and placed in the dom post-container

//ändra postsReadUrl till search.php om d e sök
const postsReadUrl = "/app/posts/read.php";
const postsUpdateUrl = "/app/posts/update.php";
const postsDeleteUrl = "/app/posts/delete.php";

const createPostBtn = document.querySelector(".post__create-btn");
const cancelPostBtn = document.querySelector(".post__cancel-btn");
const postForm = document.querySelector(".post__form");

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
