"use strict";

console.log("Profile loaded.");

const profileForm = document.querySelector(".profile__form");
const editBtn = document.querySelector(".profile__edit-btn");
const cancelBtn = document.querySelector(".profile__cancel-btn");

editBtn.addEventListener("click", () => {
    profileForm.classList.remove("hidden");
    cancelBtn.classList.remove("hidden");
    editBtn.classList.add("hidden");
});

cancelBtn.addEventListener("click", () => {
    profileForm.classList.add("hidden");
    cancelBtn.classList.add("hidden");
    editBtn.classList.remove("hidden");
});
