<?php  
  
    require_once "../class/Siswa.php";
    require_once "../class/DB.php";


  	$siswa = new Siswa($db);
  	$datas = $siswa->getSiswa();

	$siswa->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_ujian = $_REQUEST['id'];
		$datax = $siswa->getDataByID('tbl_ujian', 'id_ujian', $id_ujian);
		$dataz = $siswa->getCountByID($id_ujian, $datas['id_siswa']);
		$siswa->randomSoal($id_ujian, $datax['jumlah_soal'], $datas['id_siswa']);
		
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
	    	<h4 align="center">Soal Pilihan Ganda</h4><font color="red"><p id="countdown" align="right">Timer</p></font>
	    	<input type="hidden" value="<?php echo $datax['waktu_selesai']; ?>" id="waktu">
	    	<font color="red"><h1 align="center" id="exp"></h1></font>
	    	<font color="blue"><h3 align="right" id="x"><?php echo $dataz['total'].'/'.$datax['jumlah_soal'] ?></h3></font>
	    	<div class="table-responsive" id="target">
		        <table class="table table-hover">
		          <tbody>
		            <?php
		              $query = "SELECT * FROM temp_soal INNER JOIN tbl_soal_pg ON (temp_soal.id_soal_pg=tbl_soal_pg.id_soal_pg) WHERE temp_soal.id_siswa={$datas['id_siswa']} AND temp_soal.id_ujian={$id_ujian}";
		              $records_per_page=1;
		              $newquery = $siswa->paging($query,$records_per_page);
		              $siswa->daftarSoal($newquery);
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
	    			<a href="siswa_kalkulate.php?id=<?php echo $id_ujian ?>" class="btn btn-success btn-sm klik" onclick="return confirm('Warning!! Akhiri Ujian sekarang ..?');">Kalkulasi Nilai</a>
	    		</center>
	    	</div>
	      	
	    </div>
	    <!-- //Content -->
	    
    </div>
</div>

<script>
//$("#kalkulate").hide();
// var initialTime = localStorage.getItem('Sibuea');//Place here the total of seconds you receive on your PHP code. ie: var initialTime = <? echo $remaining; ?>;
// var starttime = parseInt(new Date(3600).getTime());
// var endtime = parseInt(new Date(3590).getTime());
// var seconds = initialTime;
// function timer() {

// 	var seconds = localStorage.getItem('Sibuea');
//     var days        = Math.floor(seconds/24/60/60);
//     var hoursLeft   = Math.floor((seconds) - (days*86400));
//     var hours       = Math.floor(hoursLeft/3600);
//     var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
//     var minutes     = Math.floor(minutesLeft/60);
//     var remainingSeconds = seconds % 60;
//     if (remainingSeconds < 10) {
//         remainingSeconds = "0" + remainingSeconds; 
//     }
//     document.getElementById('countdown').innerHTML = hours + "h " + minutes + "m " + remainingSeconds+ "s";
//     if (seconds == 0) {
//         clearInterval(countdownTimer);
//         document.getElementById('countdown').innerHTML = "EXPIRED";
//     } else {
//         seconds--;
//         localStorage.setItem("Sibuea", seconds);
//     }
// }
// var countdownTimer = setInterval('timer()', 1000);


// Set the date we're counting down to
var countDownDate = new Date($("#waktu").val()).getTime();
//var countDownDate = new Date().getTime()+3600000;

// Date.prototype.addHours = function(h) {    
//    this.setTime(this.getTime() + (h*60*60*1000)); 
//    return this;   
// }

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
        //hide(document.getElementById('target'));
        autonull();
        //hapus temp_soal + jawaban*
        $("#target").hide();
        $("#x").hide();
        $("#countdown").hide();
        $("#kalkulate").hide();
    }
}, 1000);
// $(function() {
//     $(".klik").on("click", function() {
//         autonull();
//     });
// });
function autonull () {

    $.post("siswa_autonull.php", {
       id_ujian: $("#id_ujian").val()
    },
    function(data, status) {
        
    });

}
</script>
<script>
$(function() {
    $(".stars").on("click", function() {
    	
    	// var jb = $(this).val();
    	// var id_soal_pg = $("#id_soal_pg").val();
    	// var id_ujian = $("#id_ujian").val();
    	
        $.post("siswa_proses.php", {
           jwb: $(this).val(),
           id_soal_pg: $("#id_soal_pg").val(),
           id_ujian: $("#id_ujian").val(),
           id_siswa: $("#id_siswa").val()
        },
        function(data, status) {
            // here you can get the data sent from PHP with data variable & the status of the request with status variable
            //alert("Data: " + data + "\nStatus: " + status);
            //alert(data);
            //$(".result").html(data);
        });
    });
});
</script>
<?php
	include "siswa_footer.php";
?>
