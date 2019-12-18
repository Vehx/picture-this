"use strict";

console.log("Likes loaded.");

const likeUrl = "/app/likes/likes.php";

const handleLikes = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    let currentBtn = e.srcElement;
    console.log(e);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Doing stuff on post : " + postId);
    const formData = new FormData();

    if (!currentBtn.classList.contains("btn-primary")) {
        if (currentBtn.classList.contains("post__like-btn")) {
            formData.append("like", `${postId}`);
        }
        if (currentBtn.classList.contains("post__dislike-btn")) {
            formData.append("dislike", `${postId}`);
        }
    } else {
        formData.append("remove", `${postId}`);
    }

    //     fetch(likeUrl, {
    //         method: "post",
    //         body: formData
    //     })
    //         .then(response => response.json())
    //         .then(response => {
    //             console.log(response);
    currentBtn.classList.toggle("btn-secondary");
    currentBtn.classList.toggle("btn-primary");
    //         });
};

// const dislikePost = e => {
//     let postId = e.srcElement.parentElement.dataset.id;
// console.log(e);
// console.log(e.srcElement.parentElement.dataset.id);

// console.log("Disliking post : " + postId);

// fetch(likeUrl, {
//     method: "post",
//     headers: "application/json"
// }).then();
// };
