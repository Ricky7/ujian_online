<?php

    class Guru {

        private $db; 
        private $error; 

        function __construct($db_conn) {

            $this->db = $db_conn;

            // Mulai session
            // session_start();
            if(!isset($_SESSION)){
                session_start();
            }
        }

        public function getDataByID($table, $field, $id) {

            $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE {$field}=:id");
            $stmt->execute(array(":id"=>$id));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function getCountByID($table, $field, $id) {

            $stmt = $this->db->prepare("SELECT COUNT(id_ujian) as total FROM {$table} WHERE {$field}=:id");
            $stmt->execute(array(":id"=>$id));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function login($nig, $password)
        {
            try
            {
                // Ambil data dari database
                $query = $this->db->prepare("SELECT * FROM tbl_guru WHERE nig = :nig");
                $query->bindParam(":nig", $nig);
                $query->execute();
                $data = $query->fetch();

                // Jika jumlah baris > 0
                if($query->rowCount() > 0){
                    // jika password yang dimasukkan sesuai dengan yg ada di database
                    if(password_verify($password, $data['password'])){
                        $_SESSION['user_session'] = $data['id_guru'];
                        $_SESSION['user_role'] = $data['role'];
                        return true;
                    }else{
                        $this->error = "NIG atau Password Salah";
                        return false;
                    }
                }else{
                    $this->error = "Akun tidak ada";
                    return false;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // Cek apakah Guru sudah login
        public function isGuruLoggedIn(){
            // Apakah user_session sudah ada di session
            if(isset($_SESSION['user_session']))
            {
                if($_SESSION['user_role'] == 'Guru') 
                {
                    return true;
                }
            }
        }

        public function cekLogin() {

            if(!self::isGuruLoggedIn()){
                header("location: ../index.php");
            }
        }

        // Ambil data admin yang sudah login
        public function getGuru(){
            // Cek apakah sudah login
            if(!$this->isGuruLoggedIn()){
                return false;
            }

            try {
                // Ambil data Pengurus dari database
                $query = $this->db->prepare("SELECT * FROM tbl_guru WHERE id_guru = :id");
                $query->bindParam(":id", $_SESSION['user_session']);
                $query->execute();
                return $query->fetch();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // Logout Admin
        public function logout(){
            // Hapus session
            session_destroy();
            // Hapus user_session
            unset($_SESSION['user_session']);
            return true;
        }

        public function ubahProfil($fields = array(), $id) {

            $set = '';
            $x = 1;

            foreach ($fields as $name => $value) {
                $set .= "{$name} = '{$value}'";
                if($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }

            //var_dump($set);
            $sql = "UPDATE tbl_guru SET {$set} WHERE id_guru = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        public function ubahPassword($id, $old, $new) {

            // cek old password

            $cek = "SELECT password FROM tbl_guru WHERE id_guru=:id";
            $stmt = $this->db->prepare($cek);
            $stmt->execute(array(":id"=>$id));
            $pass=$stmt->fetch(PDO::FETCH_ASSOC);

            $newPass = password_hash($new, PASSWORD_DEFAULT);

            if($stmt->rowCount()>0) {

                if(password_verify($old, $pass['password'])) {

                    // update new password
                    $new = "UPDATE tbl_guru SET password='{$newPass}' WHERE id_guru={$id}";

                    $stmtC = $this->db->prepare($new);
                    $stmtC->execute();

                    ?>
                        <div class="alert alert-success" style="height:50px;">
                            Berhasil Diubah!
                        </div>
                        <script>
                            setInterval(function() {
                                window.location.href = "guru_password.php";
                            }, 5000);
                        </script>
                    <?php
                    
                    return true;
                } else {

                    ?>
                        <div class="alert alert-danger" style="height:50px;">
                            Gagal! Coba Ulangi
                        </div>
                        <script>
                            setInterval(function() {
                                window.location.href = "guru_password.php";
                            }, 5000);
                        </script>
                    <?php
                }
            }
            
        }

        public function inputDataArray($fields = array(), $table) {

            $keys = array_keys($fields);

            $values = "'" . implode( "','", $fields ) . "'";

            $sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function inputData($table, $field, $value) {


            $sql = "INSERT INTO {$table} ($field) VALUES ('{$value}')";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function setWaktu($id, $value) {


            $sql = "UPDATE tbl_ujian SET waktu_selesai='{$value}' WHERE id_ujian = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function daftarUjian($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['nama_mapel']); ?></td>
                        <td><?php print($row['jumlah_soal']); ?></td>
                        <td><?php print($row['jenis_soal']); ?></td>
                        <td><?php print($row['nama_kelas']); ?></td>
                        <td>
                            <?php
                                switch ($row['jenis_soal']) {
                                    case 'PG':
                                        ?>
                                            <a href="guru_isi_soal.php?id=<?php echo $row['id_ujian'] ?>" onclick="return confirm('Isi Soal ..?');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        <?php
                                        break;
                                    
                                    case 'ES':
                                        ?>
                                            <a href="guru_isi_essay.php?id=<?php echo $row['id_ujian'] ?>" onclick="return confirm('Isi Soal ..?');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        <?php
                                        break;
                                }
                            ?>
                        
                        </td> 
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ada data....</td>
                </tr>
                <?php
            }

        }

        public function daftarUjian2($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['nama_mapel']); ?></td>
                        <td><?php print($row['jenis_soal']); ?></td>
                        <td><?php print($row['nama_kelas']); ?></td>
                        <td>
                        <a href="guru_nilai.php?id=<?php echo $row['id_ujian'] ?>&slug=<?php print($row['jenis_soal']); ?>" onclick="return confirm('Lihat Nilai ..?');"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
                        </td> 
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ada data....</td>
                </tr>
                <?php
            }

        }

        public function daftarUjian3($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['nama_mapel']); ?></td>
                        <td><?php print($row['jenis_soal']); ?></td>
                        <td><?php print($row['nama_kelas']); ?></td>
                        <td>
                        <a href="guru_data_peserta.php?id=<?php echo $row['id_ujian'] ?>&slug=<?php echo $row['nama_mapel'] ?>" onclick="return confirm('Lihat Peserta ..?');"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
                        </td> 
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ada data....</td>
                </tr>
                <?php
            }

        }

        public function daftarPeserta($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['nis']); ?></td>
                        <td><?php print($row['nama']); ?></td>
                        <td>
                        <a href="guru_data_jawaban.php?id=<?php echo $row['id_siswa'] ?>&slug=<?php echo $row['id_ujian'] ?>" onclick="return confirm('Lihat Jawaban ..?');"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>
                        </td> 
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ada data....</td>
                </tr>
                <?php
            }

        }

        public function daftarJawaban($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td>
                            <label>Soal</label><br>
                            <?php print($row['soal']); ?><br>
                            <small>Poin </small><font color="red"><?php print($row['poin']); ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Jawaban</label><br>
                            <?php print($row['jawaban']); ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ada data....</td>
                </tr>
                <?php
            }

        }

        public function daftarSoal($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['soal']); ?></td>
                        <td><?php print($row['jawaban']); ?></td>
                        <td>
                        <button type="button" class="btn btn-info btn-xs edit_button" 
                            data-toggle="modal" data-target="#myModalEdit"
                            data-soal="<?php print($row['soal']);?>"
                            data-a="<?php print($row['pil1']);?>"
                            data-b="<?php print($row['pil2']);?>"
                            data-c="<?php print($row['pil3']);?>"
                            data-d="<?php print($row['pil4']);?>"
                            data-jb="<?php print($row['jawaban']);?>"
                            data-id="<?php print($row['id_soal_pg']); ?>">
                            Edit
                        </button>
                        </td> 
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Belum ada soal....</td>
                </tr>
                <?php
            }

        }

        public function daftarEssay($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['soal']); ?></td>
                        <td><?php print($row['poin']); ?></td>
                        <td>
                        <button type="button" class="btn btn-info btn-xs edit_button" 
                            data-toggle="modal" data-target="#myModalEdit"
                            data-soal="<?php print($row['soal']);?>"
                            data-poin="<?php print($row['poin']);?>"
                            data-id="<?php print($row['id_soal_es']); ?>">
                            Edit
                        </button>
                        </td> 
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Belum ada soal....</td>
                </tr>
                <?php
            }

        }

        public function editSoal($fields = array(), $id) {

            $set = '';
            $x = 1;

            foreach ($fields as $name => $value) {
                $set .= "{$name} = '{$value}'";
                if($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }

            //var_dump($set);
            $sql = "UPDATE tbl_soal_pg SET {$set} WHERE id_soal_pg = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        public function editEssay($fields = array(), $id) {

            $set = '';
            $x = 1;

            foreach ($fields as $name => $value) {
                $set .= "{$name} = '{$value}'";
                if($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }

            //var_dump($set);
            $sql = "UPDATE tbl_soal_es SET {$set} WHERE id_soal_es = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        public function hapusJawaban($id_ujian, $id_siswa) {
            $stmt = $this->db->prepare("DELETE FROM tbl_jawaban_es WHERE id_ujian=:id_ujian AND id_siswa=:id_siswa");
            $stmt->bindparam(":id_ujian",$id_ujian);
            $stmt->bindparam(":id_siswa",$id_siswa);
            $stmt->execute();
            return true;
        }

        public function hapusSoal($id_ujian, $id_siswa) {
            $stmt = $this->db->prepare("DELETE FROM temp_soal WHERE id_ujian=:id_ujian AND id_siswa=:id_siswa");
            $stmt->bindparam(":id_ujian",$id_ujian);
            $stmt->bindparam(":id_siswa",$id_siswa);
            $stmt->execute();
            return true;
        }

        public function paging($query,$records_per_page)
        {
            $starting_position=0;
            if(isset($_GET["page_no"]))
            {
                $starting_position=($_GET["page_no"]-1)*$records_per_page;
            }
            $query2=$query." limit $starting_position,$records_per_page";
            return $query2;
        }

        public function paginglink($query,$records_per_page)
        {
            
            $self = $_SERVER['PHP_SELF'];
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $total_no_of_records = $stmt->rowCount();
            
            if($total_no_of_records > 0)
            {
                ?><ul class="pagination"><?php
                $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
                $current_page=1;
                if(isset($_GET["page_no"]))
                {
                    $current_page=$_GET["page_no"];
                }
                if($current_page!=1)
                {
                    $previous =$current_page-1;
                    echo "<li><a href='".$self."?page_no=1'>First</a></li>";
                    echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
                }
                for($i=1;$i<=$total_no_of_pages;$i++)
                {
                    if($i==$current_page)
                    {
                        echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
                    }
                    else
                    {
                        echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
                    }
                }
                if($current_page!=$total_no_of_pages)
                {
                    $next=$current_page+1;
                    echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
                    echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
                }
                ?></ul><?php
            }
        }

        public function paginglink2($query,$records_per_page, $id)
        {
            
            $self = $_SERVER['PHP_SELF'];
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $total_no_of_records = $stmt->rowCount();
            
            if($total_no_of_records > 0)
            {
                ?><ul class="pagination"><?php
                $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
                $current_page=1;
                if(isset($_GET["page_no"]))
                {
                    $current_page=$_GET["page_no"];
                }
                if($current_page!=1)
                {
                    $previous =$current_page-1;
                    echo "<li><a href='".$self."?page_no=1&id=".$id."'>First</a></li>";
                    echo "<li><a href='".$self."?page_no=".$previous."&id=".$id."'>Previous</a></li>";
                }
                for($i=1;$i<=$total_no_of_pages;$i++)
                {
                    if($i==$current_page)
                    {
                        echo "<li><a href='".$self."?page_no=".$i."&id=".$id."' style='color:red;'>".$i."</a></li>";
                    }
                    else
                    {
                        echo "<li><a href='".$self."?page_no=".$i."&id=".$id."'>".$i."</a></li>";
                    }
                }
                if($current_page!=$total_no_of_pages)
                {
                    $next=$current_page+1;
                    echo "<li><a href='".$self."?page_no=".$next."&id=".$id."'>Next</a></li>";
                    echo "<li><a href='".$self."?page_no=".$total_no_of_pages."&id=".$id."'>Last</a></li>";
                }
                ?></ul><?php
            }
        }

        public function getLastError() {
            return $this->error;
        }
    }

?>