<!-- Top navigation -->
<header class="topnav">
  <!-- Centered link -->
  <div class="topnav-centered">
    <a href="index.php"><img src="images/watsis_personal_care.png" class="logo"></a>
  </div>
  
  <!-- Left-aligned links (default) -->
  <!-- Use any element to open the sidenav -->
  <span onclick="openNav()">
    <div class="barscontainer" onclick="myFunction(this)">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
    </div>
  </span>
  
  <!-- Right-aligned links -->
  <div class="topnav-right">
    <span onclick="openNav2()">
      <div class="barscontainer2" onclick="myFunction(this)">
        <div class="dot1"></div>
        <div class="dot2"></div>
        <div class="dot3"></div>
      </div>
    </span>
    <a href="Contact.php">Contact Us</a>
    <a href="wishlist.php">Wishlist</a>
    <a href="cart.php">Cart</a>
    <a href="signout.php">Sign Out</a>
  </div>
</header>

<!--Side navigation menu content-->
<div class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <p style="text-decoration:underline">Categories: </p>
  <a href="itemList.php">All Products</a>
  <a href="itemList.php#BodyCare">Body Care</a>
  <a href="itemList.php#DentalCare">Dental Care</a>
  <a href="itemList.php#HairCare">Hair Care</a>
  <a href="itemList.php#SkinCare">Skin Care</a>
</div>

<div class="smallScreenSideNav">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav2()">&times;</a>
    <a href="Contact.php">Contact Us</a>
    <a href="wishlist.php">Wishlist</a>
    <a href="cart.php">Cart</a>
    <a href="signout.php">Sign Out</a>
</div>

