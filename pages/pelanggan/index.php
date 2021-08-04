<?php require_once('./header.php') ?>
<?php

if(isset($_POST['TblBeli'])) {
  if(isset($_SESSION['cart'])){

    $session_array_id = array_column($_SESSION['cart'], "id");

    if(!in_array($_GET['id'], $session_array_id)){
      $session_array = array(
        'id' => $_GET['id'],
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'qty' => $_POST['qty']
      );
  
      $_SESSION['cart'][] = $session_array;
    }

  } else {
    $session_array = array(
      'id' => $_GET['id'],
      'name' => $_POST['name'],
      'price' => $_POST['price'],
      'qty' => $_POST['qty']
    );

    $_SESSION['cart'][] = $session_array;
  }
}

$db=dbConnect();
//PROCEDURE tampilMenu() MYSQL
$data=mysqli_query($conn,"call tampilMenu()");
$jumlah_data = mysqli_num_rows($data);
?>
        <!-- Main Content -->
        <div class="main-content">
          <section class="section">
            <div class="section-header">
              <h1>Pesanan</h1> 
            </div>
            <?php 
            if (isset($_SESSION['pesan'])) {
              echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      ' . $_SESSION['pesan'] . '
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>';
            
              unset($_SESSION['pesan']);
            }
            ?>
            <div class="row">
            <?php               
            if($jumlah_data){
                foreach($data as $d) : ?>
                <form method="post" action="index.php?id=<?= $d['id_menu']; ?>">
                  <input type="hidden" name="id" value="<?= $d['id_menu']; ?>" class="form-control"></input>
                  <input type="hidden" name="price" value="<?= $d['harga_menu']; ?>" class="form-control"></input>
                  <input type="hidden" name="name" value="<?= $d['nama_menu']; ?>" class="form-control"></input>
                <div class="col-md-3">
                    <div class="card-warning bg-dark mb-3" style="width: 14rem;">
                        <img src="../../upload/menu/<?= $d['gambar']; ?>" width="100px" height="150px" class="card-img-top" style="position: relative;" alt="...">
                        <div class="card-body">
                          <div class="row">
                            <h5 class="card-title"><?= $d['nama_menu']; ?></h5>
                          </div>
                          <div class="row">
                            <h6 class="card-subtitle mb-3">Rp. <?= $d['harga_menu']; ?></h6>
                          </div>
                          <div class="row row-mt-5 justify-content-center">
                            <div class="col-sm-6">
                              <input type="number" name="qty" value="1" min="1" max="<?= $d['stok']; ?>" class="form-control"></input>
                            </div>
                          </div>
                            
                        </div>
                        <div class="card-footer text-center">    
                          <div class="row">
                            <!-- <i class="fas fa-cart-plus"></i> -->
                            <input type="submit" name="TblBeli" class="btn btn-warning btn-block shadow-none" value="Beli"></input>
                          </div>
                        
                        </div>
                    </div>
                  </div>
                </form>
                <?php endforeach; 
                } else { ?>
                <div class="stoq row justify-content-center text-center">
                <div class="row justify-content-center">
                    <div class="empty-state">
                      <div class="empty-state-icon bg-warning">
                        <i class="far fa-frown"></i>
                      </div>
                      <h2>Kami kehabisan stok</h2>
                      <p class="lead">
                        Tidak ada menu yang ditampilkan. Cobalah beberapa saat lagi.
                      </p>
                    </div>
            </div>
                </div>                
                <?php } ?>
              </div>
            </div>
          </section>
        </div>
        <?php require_once('./footer.php') ?>
</body>
</html> 