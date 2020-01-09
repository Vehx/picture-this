"use strict";

console.log("Likes loaded.");
// in this file we post liking and disliking stuff to likes.php when user likes or dislikes something
// we also change the button looks with classes once fetch is done to show user the click did something

const likeUrl = "/app/likes/likes.php";

const handleLikes = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    let currentBtn = e.srcElement;
    let otherBtn;
    // console.log(e);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Doing stuff on post : " + postId);
    const formData = new FormData();
    formData.append("exists", "false");

    // if (currentBtn.classList.contains("btn-primary") === false) {
    if (currentBtn.classList.contains("post__like-btn")) {
        otherBtn = currentBtn.nextElementSibling;
        formData.append("like", `${postId}`);
    }
    if (currentBtn.classList.contains("post__dislike-btn")) {
        otherBtn = currentBtn.previousElementSibling;
        formData.append("dislike", `${postId}`);
    }
    // } else
    if (currentBtn.classList.contains("btn-primary") === true) {
        formData.append("remove", `${postId}`);
    }
    if (otherBtn.classList.contains("btn-primary") === true) {
        formData.set("exists", "true");
    }

    fetch(likeUrl, {
        method: "post",
        body: formData
    })
        .then(response => response.json())
        .then(response => {
            console.log(response);
            currentBtn.classList.toggle("btn-secondary");
            currentBtn.classList.toggle("btn-primary");
            if (otherBtn != undefined) {
                otherBtn.classList.remove("btn-primary");
                otherBtn.classList.add("btn-secondary");
            }
        });
};
