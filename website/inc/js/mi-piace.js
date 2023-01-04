const likeButtons = document.getElementsByClassName("like-button");

function setLike(image, like, likes) {
    if(like) {
        image.setAttribute("src", "inc/img/liked.png");
        //Increment the value of the likes
        likes.firstChild.data++;
    } else {
        image.setAttribute("src", "inc/img/like.png");
        //Increment the value of the likes
        likes.firstChild.data--;
    }
}

for(let i = 0; i < likeButtons.length; i++) {
    const likeButton = likeButtons[i];
    const postId = likeButton.id;
    //The first children of the like-button is always the image, the second one is <strong> that contains the number of likes
    const image = likeButton.children[0];
    const likes = likeButton.children[1];

    likeButton.addEventListener("click", () => {

        const formData = new FormData();
        formData.append("postid", postId);
        axios.post("api/toggle-mi-piace.php", formData).then( 
        response => {
            const like = response.data;
            setLike(image, like, likes);
        });
    });
}
