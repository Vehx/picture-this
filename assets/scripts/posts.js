"use strict";

console.log("Posts loaded.");

// in this file posts are fetched if any exsists and then made into post elements and placed in the dom post-container
const postUrl = "/app/posts/read.php";

const creatPostBtn = document.querySelector(".post__create-btn");
const postForm = document.querySelector(".post__form");

creatPostBtn.addEventListener("click", () => {
    console.log("Creating post :)");
    creatPostBtn.classList.add("hidden");
    postForm.classList.remove("hidden");
});

fetch(postUrl)
    .then(response => response.json())
    .then(posts => {
        const postContainer = document.querySelector(".post__container");
        console.log(posts);

        if (!(posts.length === 0)) {
            posts.forEach(post => {
                // all elements of post is made
                let newPost = document.createElement("div");
                let h2 = document.createElement("h2");
                let a = document.createElement("a");
                let img = document.createElement("img");
                let h3 = document.createElement("h3");
                let like = document.createElement("button");
                let dislike = document.createElement("button");
                let comment = document.createElement("button");

                // todo make function postElement that makes elements and sets textContent and className
                // elements are populated with data and classes
                newPost.className = "post";
                newPost.setAttribute("data-id", post.id);

                h2.textContent = post.title;
                h2.className = "post__title";

                a.href = post.user_id;
                a.className = "post__profile-id";

                img.src = post.picture;
                img.className = "post__image";

                h3.textContent = post.keywords;
                h3.className = "post__hashtags";

                like.textContent = "Like";
                like.className = "btn btn-secondary post__like-btn";

                dislike.textContent = "Dislike";
                dislike.className = "btn btn-secondary post__dislike-btn";

                comment.textContent = "Comment";
                comment.className = "btn btn-secondary post__comment-btn";

                // todo make into funcion highlightButton
                if (post.liked === "1") {
                    like.classList.add("btn-primary");
                    like.classList.remove("btn-secondary");
                }
                if (post.disliked === "1") {
                    dislike.classList.add("btn-primary");
                    dislike.classList.remove("btn-secondary");
                }

                // elements gets put inside post div
                newPost.appendChild(h2);
                newPost.appendChild(a);
                newPost.appendChild(img);
                newPost.appendChild(h3);
                newPost.appendChild(like);
                newPost.appendChild(dislike);
                newPost.appendChild(comment);

                // post div is put in dom
                postContainer.appendChild(newPost);
                // console.log(newPost);
            });

            // grabbing all like and dislike buttons for eventlistener adding
            const likeButtons = document.querySelectorAll(".post__like-btn");
            const dislikeButtons = document.querySelectorAll(
                ".post__dislike-btn"
            );

            // adds like click eventlistener, functions are in likes.js
            likeButtons.forEach(likeButton => {
                likeButton.addEventListener("click", handleLikes);
            });
            // adds dislike click eventlistener
            dislikeButtons.forEach(dislikeButton => {
                dislikeButton.addEventListener("click", handleLikes);
            });
        } else {
            const div = document.createElement("div");
            div.textContent = "There are no posts here yet.";
            postContainer.appendChild(div);
        }
    });
