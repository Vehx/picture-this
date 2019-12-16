"use strict";

const url = "/app/posts/read.php";

fetch(url)
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

                // elements are populated with data and classes
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
                dislike.className = "btn btn-secondary post__like-btn";

                // elements gets put inside post div
                newPost.appendChild(h2);
                newPost.appendChild(a);
                newPost.appendChild(img);
                newPost.appendChild(h3);
                newPost.appendChild(like);
                newPost.appendChild(dislike);

                // post div is put in dom
                postContainer.appendChild(newPost);
                console.log(newPost);
            });
        } else {
            const div = document.createElement("div");
            div.textContent = "There are no posts here yet.";
            postContainer.appendChild(div);
        }
    });
