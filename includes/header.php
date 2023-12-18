<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Lab 7</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       
      <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="destination.php">View-Destination</a>
        </li>
        <?php if(isset($_SESSION['user'])){ ?>
          <li class="nav-item">
          <a class="nav-link active" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="add-destination.php">Add-Destination</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="edit-destination.php">Edit-Destination</a>
        </li>
     <?php   } 
     
     else {?>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Login</a>
        </li>
    <?php  } ?> 
    <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="join-us.php">Join-Us</a>
        </li>
      </ul>
      <form class="d-flex" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" >
      <input class="form-control me-2" type="search" name="search" placeholder="search by name/airport" aria-label="Search" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">

        <button class="btn btn-outline-success" name="submit" type="submit">Search</button>
        <button class="btn btn-outline-secondary ml-2" name="clear" type="submit">Clear</button>
      </form>
    </div>
  </div>
</nav>
    </header>