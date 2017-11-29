<?php  
  
    require_once "../class/Siswa.php";
    require_once "../class/DB.php";


  	$siswa = new Siswa($db);
  	$datas = $siswa->getSiswa();

	$siswa->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_ujian = $_REQUEST['id'];
		$datax = $siswa->getDataByID('tbl_ujian', 'id_ujian', $id_ujian);
		$dataz = $siswa->getEssayByID($id_ujian, $datas['id_siswa']);
		$siswa->randomEssay($id_ujian, $datax['jumlah_soal'], $datas['id_siswa']);
		
	}

?>
<?php
	include "siswa_header.php";
	include "siswa_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
    	 	<li><a href="siswa_menu_ujian.php">Daftar Ujian</a></li>
    	 	<li class="active">Isi</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-12">
	    	<input type="hidden" id="id_siswa" value="<?php echo $datas['id_siswa']; ?>">
	    	<h4 align="center">Soal Essay</h4><font color="red"><p id="countdown" align="right">Timer</p></font>
	    	<input type="hidden" value="<?php echo $datax['waktu_selesai']; ?>" id="waktu">
	    	<font color="red"><h1 align="center" id="exp"></h1></font>
	    	<font color="blue"><h3 align="right" id="x"><?php echo $dataz['total'].'/'.$datax['jumlah_soal'] ?></h3></font>
	    	<div class="table-responsive" id="target">
		        <table class="table table-hover">
		          <tbody>
		            <?php
		              $query = "SELECT * FROM temp_soal INNER JOIN tbl_soal_es ON (temp_soal.id_soal_pg=tbl_soal_es.id_soal_es) WHERE temp_soal.id_siswa={$datas['id_siswa']} AND temp_soal.id_ujian={$id_ujian}";
		              $records_per_page=1;
		              $newquery = $siswa->paging($query,$records_per_page);
		              $siswa->daftarEssay($newquery);
		             ?>
		             <tr>
		                <td colspan="5" align="center">
		              		<div class="pagination-wrap">
			                    <?php $siswa->paginglink3($query,$records_per_page, $id_ujian); ?>
			                </div>
		                </td>
		            </tr>
		          </tbody>
		        </table>
	        </div>
	        <div id="kalkulate">
	    		<center>
	    			<a href="siswa_menu_ujian.php" class="btn btn-success btn-sm" onclick="return confirm('Warning!! Akhiri Ujian sekarang ..?');">Selesai</a>
	    		</center>
	    	</div>
	      	
	    </div>
	    <!-- //Content -->
	    
    </div>
</div>
<script>
function autosave () {

    //var jawaban = $("#id_soal_es").val();
    //alert('work');
    //alert(jawaban);
    $.post("siswa_autosave.php", {
       jawaban: $("#jawaban").val(),
       id_soal_es: $("#id_soal_es").val(),
       id_ujian: $("#id_ujian").val(),
       id_siswa: $("#id_siswa").val()
    },
    function(data, status) {
        
    });

}
var x = setInterval('autosave()', 500);

</script>
<script>

// Set the date we're counting down to
var countDownDate = new Date($("#waktu").val()).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    //alert(distance);
    
    // Time calculations for days, hours, minutes and seconds
    //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("countdown").innerHTML = hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("exp").innerHTML = "EXPIRED";

        $("#target").hide();
        $("#x").hide();
        $("#countdown").hide();

    }
}, 1000);
</script>

<?php
	include "siswa_footer.php";
?>
