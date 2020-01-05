"use strict";

console.log("Profile loaded.");

const profileForm = document.querySelector(".profile__form");
const editBtn = document.querySelector(".profile__edit-btn");

editBtn.addEventListener("click", () => {
    profileForm.classList.remove("hidden");
    editBtn.classList.add("hidden");
});
