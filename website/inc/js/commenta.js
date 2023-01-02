const commentaTitle = document.querySelector("form.commenta h3");
const hiddenInput = document.querySelector("form.commenta input[name='commento']");
const cancelReplyButton = document.getElementById("cancel-reply-button");

function rispondiWasPressed(idCommento, usernCommentatore) {
    hiddenInput.value = idCommento;

    commentaTitle.innerHTML = "Stai rispondendo a <strong>"+ usernCommentatore +"</strong>";
    commentaTitle.scrollIntoView();

    cancelReplyButton.classList.remove("d-none");
    cancelReplyButton.classList.add("d-inline-block");
}

cancelReplyButton.addEventListener('click', () => {
    hiddenInput.value = "";
    
    commentaTitle.innerHTML = "Stai commentando";
    
    cancelReplyButton.classList.remove("d-inline-block");
    cancelReplyButton.classList.add("d-none");
});
