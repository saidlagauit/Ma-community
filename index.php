<?php
	session_start();
	include 'init.php';
  require('fpdf.php');
  $do = isset($_GET['do']) ? $_GET['do'] : 'home';
  $theSheet = getLatest("*","sheet","id");
  if($do == 'home') {
    ?>
      <div class="row g-3 text-uppercase">
        <div class="col-md-6">
          <div class="title"><h1>Sigh-up Sheet</h1></div>
        </div>
        <div class="col-md-6">
          <div class="date-event  h1">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-leaf"></i></span>
              <input type="text" class="form-control" placeholder="title event"/>
            </div>
            <div class="input-group mb-3">
              <input type="date" class="form-control" />
            </div>
          </div>
        </div>
      </div>
    <table class="table table-bordered border-dark">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Phone Number</th>
          <th>Email Address</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php
          foreach($theSheet as $sheet) {
            echo '
              <tr>
                <td><form class="delete" method="post" action="?do=delete-user">
                    <input type="hidden" name="id" value="' . $sheet['id'] . '">
                    <button type="submit" class="btn btn-danger"><i class="fa-sharp fa-solid fa-x"></i></button>
                  </form>
                </td>
                <td>' . $sheet['name'] . '</td>
                <td>' . $sheet['phone'] . '</td>
                <td>' . $sheet['email'] . '</td>
              </tr>';
          }
        ?>
      </tbody>
    </table>
    <a href="?do=new-add" class="btn btn-add btn-dark"><i class="fa-solid fa-user-plus"></i></a>
    <a onclick="print()" class="btn btn-print btn-primary"><i class="fa-solid fa-print"></i></a>
  <?php
  } elseif ($do == 'delete-user'){
    $id = $_POST['id'];
    $stmt = $con->prepare("DELETE FROM sheet WHERE `sheet`.`id` = ?");
    $stmt->execute(array($id));
    header('Refresh: 0.1; url=?do=home');
    exit();
  } elseif ($do == 'new-add') {
    ?><div class="new-add">
      <form class="insert" action="?do=insert" method="post" autocomplete="off">
        <h3><i class="fa-solid fa-user-plus"></i>&nbsp;Add New</h3>
        <div class="form-floating mb-3">
          <input type="text" name="name" class="form-control" />
          <label for="floatingInput">Name</label>
        </div>
        <div class="form-floating mb-3">
          <input type="number" name="phone" class="form-control"/>
          <label for="floatingInput">Phone Number</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" name="email" class="form-control" />
          <label for="floatingInput">Email Address</label>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Save</button>
        <a href="?do=home" class="btn btn-outline-secondary">Back</a>
      </form>
    </div><?php
  } elseif ($do == 'insert'){
    if(!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email'])) {
      $name   = $_POST['name'];
      $phone  = $_POST['phone'];
      $email  = $_POST['email'];
      $stmt = $con->prepare("INSERT INTO `sheet`(`name`, `phone`, `email`) VALUES (?,?,?)");
      $stmt->execute([$name,$phone,$email]);    
      echo '<div class="alert alert-success"><h4 class="alert-heading">Record Inserted</h4></div>';
      header('Refresh: 0.1; url=?do=home'); // Redirect To Index page
      exit();
    } else {
      echo '<div class="alert alert-danger"><h4 class="alert-heading">Please fill all fields</h4></div><a href="?do=home" class="btn btn-dark">Back</a>';
      exit();
    }
  }
  include $tpl . 'footer.php';?>
