<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();

	$admin->cekLogin();

?>
<?php
	include "admin_header.php";
	include "admin_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
	      <li class="active">Data Jurusan</li>
	      <li><a href="admin_input_jur.php">Input Jurusan</a></li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-8 col-md-offset-2">
	    	<h4 align="center">Data Jurusan</h4>
	    	
	    	<div class="table-responsive">
		        <table class="table table-hover">
		          <thead>
		            <th>#</th>
		            <th>Nama Jurusan</th>
		            <th colspan="2">Opsi</th>
		          </thead>
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_jurusan ORDER BY id_jurusan asc";       
		              $records_per_page=10;
		              $newquery = $admin->paging($query,$records_per_page);
		              $admin->daftarJurusan($newquery);
		             ?>
		             <tr>
		                <td colspan="4" align="center">
		              		<div class="pagination-wrap">
			                    <?php $admin->paginglink($query,$records_per_page); ?>
			                </div>
		                </td>
		            </tr>
		          </tbody>
		        </table>
	        </div>
	      	
	    </div>
	    <!-- //Content -->
    </div>
</div>
<?php
	include "admin_footer.php";
?>