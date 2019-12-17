"use strict";

console.log("Likes loaded.");

const likePost = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    // console.log(e);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Liking post : " + postId);

    // fetch(url, {
    //     method: "post",
    //     headers: "application/json"
    // }).then();
};

const dislikePost = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    // console.log(e);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Disliking post : " + postId);

    // fetch(url, {
    //     method: "post",
    //     headers: "application/json"
    // }).then();
};
