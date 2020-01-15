"use strict";

console.log("Posts loaded.");

// in this file posts are fetched if any exsists and then made into post elements and placed in the dom post-container
const postsReadUrl = "/app/posts/read.php";
const postsUpdateUrl = "/app/posts/update.php";
const postsDeleteUrl = "/app/posts/delete.php";

const createPostBtn = document.querySelector(".post__create-btn");
const cancelPostBtn = document.querySelector(".post__cancel-btn");
const postForm = document.querySelector(".post__form");

// function to delete post, after its posts to server it hides the post
const handleRemove = e => {
    let postId = e.srcElement.parentElement.dataset.id;

    const formData = new FormData();
    formData.append("post-id", `${postId}`);

    fetch(postsDeleteUrl, {
        method: "post",
        body: formData
    }).then(() => {
        e.srcElement.parentElement.classList.add("hidden");
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
                // a new post is made
                let newPost = document.createElement("div");

                // elements are populated with data and classes
                newPost.className = "border p-2 my-2 mw-100 mvh-80 post";
                newPost.setAttribute("data-id", post.id);

                // start of originalPoster box creation
                let originalPosterBox = document.createElement("div");
                let originalPosterImg = document.createElement("img");
                let originalPosterLink = document.createElement("a");
                originalPosterBox.className = "post__poster-container";

                originalPosterImg.src = post.poster_avatar;
                originalPosterImg.alt = post.poster_name + "'s avatar image";
                originalPosterImg.className = "rounded-circle";
                originalPosterImg.height = "75";
                originalPosterImg.width = "75";

                originalPosterLink.textContent = post.poster_name;
                originalPosterLink.href = "/profile.php?uid=" + post.user_id;
                originalPosterLink.className = "post__profile-id";

                originalPosterBox.appendChild(originalPosterImg);
                originalPosterBox.appendChild(originalPosterLink);
                // end of originalPoster box creation

                // start of main post box creation
                let postContentBox = document.createElement("div");
                let img = document.createElement("img");
                let p = document.createElement("p");
                postContentBox.className = "m-1 mvh-75 post__content";

                img.src = post.image;
                img.className = "mw-100 post__image";

                p.textContent = post.description;
                p.className = "post__description";

                postContentBox.appendChild(img);
                postContentBox.appendChild(p);
                //end of main post box creation

                // start of like box creation
                let likeBox = document.createElement("div");
                let likes = document.createElement("span");
                let likeBtn = document.createElement("button");
                let dislikeBtn = document.createElement("button");

                likeBox.className = "mw-50";

                likes.textContent = post.likes;
                likes.className = "mx-2 post__likes";

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
                likeBox.appendChild(likes);
                likeBox.appendChild(likeBtn);
                likeBox.appendChild(dislikeBtn);
                // end of like box creation

                // elements gets put inside post div
                newPost.appendChild(originalPosterBox);
                newPost.appendChild(postContentBox);
                newPost.appendChild(likeBox);

                // elements gets made that should only show if post is from current user
                if (parseInt(userId) === parseInt(post.user_id)) {
                    let postOptions = document.createElement("div");
                    let edit = document.createElement("button");
                    let cancelEdit = document.createElement("button");
                    let remove = document.createElement("button");
                    let editForm = document.createElement("form");

                    const editFormTemplate = `<input type="hidden" name="post-id" id="post-id" value="${post.id}">
                    <div class="form-group">
                    <label for="edit-description">Description: </label>
                    <input type="text" name="edit-description" id="edit-description" value="${post.description}">
                    </div><!-- /form-group -->
                    <button type="submit" class="ml-1 mt-1 btn btn-primary post__submit-edit-btn">Save</button>`;

                    editForm.innerHTML = editFormTemplate;
                    editForm.action = "app/posts/update.php";
                    editForm.method = "post";
                    editForm.enctype = "multipart/form-data";
                    editForm.classList = "post__edit-form hidden";

                    edit.textContent = "Edit";
                    edit.className =
                        "ml-1 mt-1 btn btn-secondary btn-sm post__edit-btn";

                    cancelEdit.textContent = "Cancel";
                    cancelEdit.className =
                        "ml-1 mt-1 btn btn-secondary btn-sm post__cancel-edit-btn hidden";

                    remove.textContent = "Delete";
                    remove.className =
                        "ml-1 mt-1 btn btn-secondary btn-sm post__remove-btn";

                    postOptions.appendChild(editForm);
                    postOptions.appendChild(edit);
                    postOptions.appendChild(cancelEdit);
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
            const cancelEditBtns = document.querySelectorAll(
                ".post__cancel-edit-btn"
            );
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
                    editBtn.addEventListener("click", e => {
                        e.srcElement.parentElement.firstChild.classList.remove(
                            "hidden"
                        );
                        e.srcElement.classList.add("hidden");
                        e.srcElement.nextSibling.classList.remove("hidden");
                        console.log(e.srcElement);
                    });
                });
            }

            // adds cancel edit click eventlistener to all cancel edit buttons
            if (cancelEditBtns != undefined) {
                cancelEditBtns.forEach(cancelEditBtn => {
                    cancelEditBtn.addEventListener("click", e => {
                        e.srcElement.parentElement.firstChild.classList.add(
                            "hidden"
                        );
                        e.srcElement.previousSibling.classList.remove("hidden");
                        e.srcElement.classList.add("hidden");
                    });
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
