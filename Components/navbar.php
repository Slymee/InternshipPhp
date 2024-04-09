<nav class="navigation-bar">
    <div class="brand-container"><span>Diary Entry</span></div>
    <div class="navigation-list">
        <ul>
            <li>Home</li>
            <li>Profile</li>
            <li>About Us</li>
            <li class="dropdown">
                    <input type="button" value="<?php echo $_SESSION['user'];?>" onclick="myFunction()" class="dropbtn">
                    <div id="myDropdown" class="dropdown-content">
                        <a href="./change-password.php">Change Password</a>
                        <a href="./Partials/logout.php">Logout</a>
                    </div>
            </li>
        </ul>
    </div>
</nav>

<script>
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>