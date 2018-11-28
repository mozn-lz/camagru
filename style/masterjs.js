function confirmation() {
    var confirm = prompt("Are you ssure you want to delete your account?\nEnter your password");
    if (confirm != null) {
        document.getElementById("delete_user").value = "confirm"
    }
}