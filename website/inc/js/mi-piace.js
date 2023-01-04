const likeButtons = document.getElementsByClassName("likeButton");

for(let i = 0; i < likeButtons.length; i++) {
    const likeButton = likeButtons[i];
    const postId = likeButton.id;

    likeButton.addEventListener("click", () => {

        const formData = new FormData();
        formData.append("postid", postId);
        axios.post("api/toggle-mi-piace.php", formData).then( 
        response => {
            
        });
    });
}
