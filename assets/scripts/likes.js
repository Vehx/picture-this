"use strict";

console.log("Likes loaded.");

const likeUrl = "/app/likes/likes.php";

const likePost = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    // console.log(e);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Liking post : " + postId);
    const formData = new FormData();
    formData.append("like", `${postId}`);

    fetch(likeUrl, {
        method: "post",
        body: formData
    })
        .then(response => response.json())
        .then(console.log);
};

const dislikePost = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    // console.log(e);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Disliking post : " + postId);

    // fetch(likeUrl, {
    //     method: "post",
    //     headers: "application/json"
    // }).then();
};
