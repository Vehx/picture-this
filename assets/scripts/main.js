"use strict";

console.log("Hello World");

const creatPostBtn = document.querySelector(".create-post-btn");
const postForm = document.querySelector(".post-form");

creatPostBtn.addEventListener("click", () => {
    console.log("Creating post :)");
    creatPostBtn.classList.add("hidden");
    postForm.classList.remove("hidden");
});
