"use strict";

console.log("Posts loaded.");

// in this file posts are fetched if any exsists and then made into post elements and placed in the dom post-container
const postsReadUrl = "/app/posts/read.php";
const postsUpdateUrl = "/app/posts/update.php";
const postsDeleteUrl = "/app/posts/delete.php";

const createPostBtn = document.querySelector(".post__create-btn");
const cancelPostBtn = document.querySelector(".post__cancel-btn");
const postForm = document.querySelector(".post__form");

const handleEdit = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    console.log(e.srcElement);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Editing post : " + postId);
    // const formData = new FormData();
    // formData.append("post-id", `${postId}`);

    // fetch(postsUpdateUrl, {
    //     method: "post",
    //     body: formData
    // }).then();
};

const handleRemove = e => {
    let postId = e.srcElement.parentElement.dataset.id;
    console.log(e);
    // console.log(e.srcElement.parentElement.dataset.id);

    console.log("Removing post : " + postId);
    const formData = new FormData();
    formData.append("post-id", `${postId}`);

    fetch(postsDeleteUrl, {
        method: "post",
        body: formData
    });
};

createPostBtn.addEventListener("click", () => {
    console.log("Creating post :)");
    createPostBtn.classList.add("hidden");
    cancelPostBtn.classList.remove("hidden");
    postForm.classList.remove("hidden");
});

cancelPostBtn.addEventListener("click", () => {
    console.log("Canceling post making :(");
    createPostBtn.classList.remove("hidden");
    cancelPostBtn.classList.add("hidden");
    postForm.classList.add("hidden");
});

fetch(postsReadUrl)
    .then(response => response.json())
    .then(posts => {
        const postContainer = document.querySelector(".post__container");
        console.log(posts);

        if (!(posts.length === 0)) {
            posts.forEach(post => {
                // all elements of post is made
                let newPost = document.createElement("div");
                // let h4 = document.createElement("h4");
                let a = document.createElement("a");
                let img = document.createElement("img");
                let p = document.createElement("p");
                let likes = document.createElement("p");
                let likeBtn = document.createElement("button");
                let dislikeBtn = document.createElement("button");

                // todo make function postElement that makes elements and sets textContent and className
                // elements are populated with data and classes
                newPost.className = "border py-3 mw-100 mvh-80 post";
                newPost.setAttribute("data-id", post.id);

                // h4.textContent = post.title;
                // h4.className = "post__title";

                a.textContent = post.poster_name;
                a.href = "/profile.php?uid=" + post.user_id;
                a.className = "post__profile-id";

                img.src = post.image;
                img.className = "mw-100 post__image";

                p.textContent = post.description;
                p.className = "post__description";

                likes.textContent = post.likes;
                likes.className = "post__likes";

                likeBtn.textContent = "Like";
                likeBtn.className =
                    "ml-1 mt-1 btn btn-secondary post__like-btn";

                dislikeBtn.textContent = "Dislike";
                dislikeBtn.className =
                    "ml-1 mt-1 btn btn-secondary post__dislike-btn";

                // like or dislike gets highlighted
                if (post.liked === "1") {
                    likeBtn.classList.add("btn-primary");
                    likeBtn.classList.remove("btn-secondary");
                }
                if (post.disliked === "1") {
                    dislikeBtn.classList.add("btn-primary");
                    dislikeBtn.classList.remove("btn-secondary");
                }

                // elements gets put inside post div
                // newPost.appendChild(h4);
                newPost.appendChild(a);
                newPost.appendChild(img);
                newPost.appendChild(p);
                newPost.appendChild(likes);
                newPost.appendChild(likeBtn);
                newPost.appendChild(dislikeBtn);

                // elements gets made that should only show if post is from current user
                if (userId === post.user_id) {
                    let postOptions = document.createElement("div");
                    let edit = document.createElement("button");
                    let save = document.createElement("button");
                    let remove = document.createElement("button");
                    let editFrom = document.createElement("form");

                    const editFromTemplate = `<div class="form-group">
                        <label for="edit-image">Image : </label>
                        <input type="file" name="edit-image" id="edit-image" accept="jpeg, jpg, png">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label for="edit-description">Description (optional) : </label>
                        <input type="text" name="edit-description" id="edit-description">
                    </div><!-- /form-group -->
                    <button type="submit" class="ml-1 mt-1 btn btn-primary post__submit-edit-btn">Save</button>`;
                    editFrom.innerHTML = editFromTemplate;

                    edit.textContent = "Edit";
                    edit.className =
                        "ml-1 mt-1 btn btn-secondary btn-sm post__edit-btn";

                    save.textContent = "Save";
                    save.className =
                        "ml-1 mt-1 btn btn-secondary post__save-btn hidden";

                    remove.textContent = "Delete";
                    remove.className =
                        "ml-1 mt-1 btn btn-secondary btn-sm post__remove-btn";

                    postOptions.appendChild(edit);
                    postOptions.appendChild(save);
                    postOptions.appendChild(remove);
                    newPost.appendChild(postOptions);
                }
                // post div is put in dom
                postContainer.appendChild(newPost);
            });

            // grabbing all like and dislike buttons for eventlistener adding
            const likeBtns = document.querySelectorAll(".post__like-btn");
            const dislikeBtns = document.querySelectorAll(".post__dislike-btn");
            const editBtns = document.querySelectorAll(".post__edit-btn");
            const saveBtns = document.querySelectorAll(".post__save-btn");
            const removeBtns = document.querySelectorAll(".post__remove-btn");

            // adds like click eventlistener, functions are in likes.js
            likeBtns.forEach(likeBtn => {
                likeBtn.addEventListener("click", handleLikes);
            });

            // adds dislike click eventlistener
            dislikeBtns.forEach(dislikeBtn => {
                dislikeBtn.addEventListener("click", handleLikes);
            });

            // adds edit click eventlistener to all edit buttons
            if (editBtns != undefined) {
                editBtns.forEach(editBtn => {
                    editBtn.addEventListener("click", () => {});
                });
            }

            // adds save edit click eventlistener to all save buttons
            if (saveBtns != undefined) {
                saveBtns.forEach(saveBtn => {
                    saveBtn.addEventListener("click", handleRemove);
                });
            }

            // adds remove click eventlistener to all remove buttons
            if (removeBtns != undefined) {
                removeBtns.forEach(removeBtn => {
                    removeBtn.addEventListener("click", handleRemove);
                });
            }
        } else {
            const div = document.createElement("div");
            div.textContent = "There are no posts here yet.";
            postContainer.appendChild(div);
        }
    });
