<?php

    class Siswa {

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

        public function getCountByID($id_ujian, $id_siswa) {

            $stmt = $this->db->prepare("SELECT COUNT(id_jawaban_pg) as total FROM tbl_jawaban_pg WHERE id_ujian=:id_ujian AND id_siswa=:id_siswa");
            $stmt->execute(array(":id_ujian"=>$id_ujian, ":id_siswa"=>$id_siswa));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function getEssayByID($id_ujian, $id_siswa) {

            $stmt = $this->db->prepare("SELECT COUNT(id_jawaban_es) as total FROM tbl_jawaban_es WHERE id_ujian=:id_ujian AND id_siswa=:id_siswa");
            $stmt->execute(array(":id_ujian"=>$id_ujian, ":id_siswa"=>$id_siswa));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function getAnswerByID($id_ujian, $id_siswa) {

            $stmt = $this->db->prepare("SELECT COUNT(id_jawaban_pg) as total FROM tbl_jawaban_pg WHERE id_ujian=:id_ujian AND id_siswa=:id_siswa AND status=1");
            $stmt->execute(array(":id_ujian"=>$id_ujian, ":id_siswa"=>$id_siswa));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function getNilaiByID($id_ujian, $id_siswa) {

            $stmt = $this->db->prepare("SELECT nilai FROM tbl_nilai WHERE id_ujian=:id_ujian AND id_siswa=:id_siswa");
            $stmt->execute(array(":id_ujian"=>$id_ujian, ":id_siswa"=>$id_siswa));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function login($nis, $password)
        {
            try
            {
                // Ambil data dari database
                $query = $this->db->prepare("SELECT * FROM tbl_siswa WHERE nis = :nis");
                $query->bindParam(":nis", $nis);
                $query->execute();
                $data = $query->fetch();

                // Jika jumlah baris > 0
                if($query->rowCount() > 0){
                    // jika password yang dimasukkan sesuai dengan yg ada di database
                    if(password_verify($password, $data['password'])){
                        $_SESSION['user_session'] = $data['id_siswa'];
                        $_SESSION['user_role'] = $data['role'];
                        return true;
                    }else{
                        $this->error = "NIS atau Password Salah";
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
            $sql = "UPDATE tbl_siswa SET {$set} WHERE id_siswa = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        // Cek apakah Admin sudah login
        public function isSiswaLoggedIn(){
            // Apakah user_session sudah ada di session
            if(isset($_SESSION['user_session']))
            {
                if($_SESSION['user_role'] == 'Siswa') 
                {
                    return true;
                }
            }
        }

        public function cekLogin() {

            if(!self::isSiswaLoggedIn()){
                header("location: ../index.php");
            }
        }

        // Ambil data admin yang sudah login
        public function getSiswa(){
            // Cek apakah sudah login
            if(!$this->isSiswaLoggedIn()){
                return false;
            }

            try {
                // Ambil data Pengurus dari database
                $query = $this->db->prepare("SELECT * FROM tbl_siswa WHERE id_siswa = :id");
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

        public function ubahPassword($id, $old, $new) {

            // cek old password

            $cek = "SELECT password FROM tbl_siswa WHERE id_siswa=:id";
            $stmt = $this->db->prepare($cek);
            $stmt->execute(array(":id"=>$id));
            $pass=$stmt->fetch(PDO::FETCH_ASSOC);

            $newPass = password_hash($new, PASSWORD_DEFAULT);

            if($stmt->rowCount()>0) {

                if(password_verify($old, $pass['password'])) {

                    // update new password
                    $new = "UPDATE tbl_siswa SET password='{$newPass}' WHERE id_siswa={$id}";

                    $stmtC = $this->db->prepare($new);
                    $stmtC->execute();

                    ?>
                        <div class="alert alert-success" style="height:50px;">
                            Berhasil Diubah!
                        </div>
                        <script>
                            setInterval(function() {
                                window.location.href = "siswa_password.php";
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
                                window.location.href = "siswa_password.php";
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

        public function setNull($id_ujian, $null) {

            $sql = "UPDATE tbl_ujian SET waktu_selesai={$null} WHERE id_ujian = {$id_ujian}" ;

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        public function updateNilai($value, $id_ujian, $id_siswa) {


            $sql = "UPDATE tbl_nilai SET nilai='{$value}' WHERE id_ujian = {$id_ujian} AND id_siswa = {$id_siswa}";

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
                                            <a href="siswa_soal.php?id=<?php echo $row['id_ujian'] ?>" onclick="return confirm('Mulai Mengerjakan Soal ..?');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        <?php
                                        break;
                                    
                                    case 'ES':
                                        ?>
                                            <a href="siswa_essay.php?id=<?php echo $row['id_ujian'] ?>" onclick="return confirm('Mulai Mengerjakan Soal ..?');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
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

        public function daftarNilai($query) {

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
                        <td><?php print($row['nilai']); ?></td>
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

        public function randomSoal($id_ujian, $jumlah_soal, $id_siswa) {

            $sql = "SELECT * FROM temp_soal WHERE id_ujian={$id_ujian} AND id_siswa={$id_siswa}";
            $go = $this->db->prepare($sql);
            $go->execute();
            //echo $go->rowCount();

            if($go->rowCount() == 0) {

                $query = "SELECT id_soal_pg FROM tbl_soal_pg WHERE id_ujian={$id_ujian} ORDER BY RAND() LIMIT {$jumlah_soal}";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                $results=$stmt->fetchAll();
            
                if($stmt->rowCount() > 0)
                {

                    foreach ($results as $row) {

                        $move_data = "INSERT INTO temp_soal (id_soal_pg, id_ujian, id_siswa) 
                        VALUES ((SELECT id_soal_pg FROM tbl_soal_pg WHERE id_soal_pg={$row['id_soal_pg']}), {$id_ujian}, {$id_siswa}) ";

                        $this->db->prepare($move_data);
                        $this->db->exec($move_data);

                    }
                }
                else
                {
                    ?>
                     <p>Data Kurang dari Jumlah Soal yang ditentukan...!</p>
                    <?php
                }

            } else if($go->rowCount() != $jumlah_soal) {

                $delSoal = "DELETE FROM temp_soal WHERE id_ujian={$id_ujian} AND id_siswa={$id_siswa}";

                if($this->db->exec($delSoal)) {

                    $query = "SELECT id_soal_pg FROM tbl_soal_pg WHERE id_ujian={$id_ujian} ORDER BY RAND() LIMIT {$jumlah_soal}";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute();
                    $results=$stmt->fetchAll();
                
                    if($stmt->rowCount() > 0)
                    {

                        foreach ($results as $row) {

                            $move_data = "INSERT INTO temp_soal (id_soal_pg, id_ujian, id_siswa) 
                            VALUES ((SELECT id_soal_pg FROM tbl_soal_pg WHERE id_soal_pg={$row['id_soal_pg']}), {$id_ujian}, {$id_siswa}) ";

                            $this->db->prepare($move_data);
                            $this->db->exec($move_data);

                        }
                    }
                    else
                    {
                        ?>
                         <p>Data Kurang dari Jumlah Soal yang ditentukan...!</p>
                        <?php
                    }

                }

            }

        }

        public function randomEssay($id_ujian, $jumlah_soal, $id_siswa) {

            $sql = "SELECT * FROM temp_soal WHERE id_ujian={$id_ujian} AND id_siswa={$id_siswa}";
            $go = $this->db->prepare($sql);
            $go->execute();
            //echo $go->rowCount();

            if($go->rowCount() == 0) {

                $query = "SELECT id_soal_es FROM tbl_soal_es WHERE id_ujian={$id_ujian} ORDER BY RAND() LIMIT {$jumlah_soal}";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                $results=$stmt->fetchAll();
            
                if($stmt->rowCount() > 0)
                {

                    foreach ($results as $row) {

                        $move_data = "INSERT INTO temp_soal (id_soal_pg, id_ujian, id_siswa) 
                        VALUES ((SELECT id_soal_es FROM tbl_soal_es WHERE id_soal_es={$row['id_soal_es']}), {$id_ujian}, {$id_siswa}) ";

                        $this->db->prepare($move_data);
                        $this->db->exec($move_data);

                    }
                }
                else
                {
                    ?>
                     <p>Data Kurang dari Jumlah Soal yang ditentukan...!</p>
                    <?php
                }

            } else if($go->rowCount() != $jumlah_soal) {

                $delSoal = "DELETE FROM temp_soal WHERE id_ujian={$id_ujian} AND id_siswa={$id_siswa}";

                if($this->db->exec($delSoal)) {

                    $query = "SELECT id_soal_es FROM tbl_soal_es WHERE id_ujian={$id_ujian} ORDER BY RAND() LIMIT {$jumlah_soal}";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute();
                    $results=$stmt->fetchAll();
                
                    if($stmt->rowCount() > 0)
                    {

                        foreach ($results as $row) {

                            $move_data = "INSERT INTO temp_soal (id_soal_pg, id_ujian, id_siswa) 
                            VALUES ((SELECT id_soal_es FROM tbl_soal_es WHERE id_soal_es={$row['id_soal_es']}), {$id_ujian}, {$id_siswa}) ";

                            $this->db->prepare($move_data);
                            $this->db->exec($move_data);

                        }
                    }
                    else
                    {
                        ?>
                         <p>Data Kurang dari Jumlah Soal yang ditentukan...!</p>
                        <?php
                    }

                }

            }

        }

        public function daftarSoal($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            //echo $stmt->rowCount();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $stmt = $this->db->prepare("SELECT * FROM tbl_jawaban_pg WHERE id_soal_pg=:id_soal_pg AND id_ujian=:id_ujian AND id_siswa=:id_siswa");
                    $stmt->execute(array(":id_soal_pg"=>$row['id_soal_pg'], ":id_ujian"=>$row['id_ujian'], ":id_siswa"=>$row['id_siswa']));
                    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form>
                        <tr>
                            <td>
                                <?php echo $row['soal'] ?>
                                <input type="hidden" id="id_soal_pg" value="<?php echo $row['id_soal_pg']; ?>">
                                <input type="hidden" id="id_ujian" value="<?php echo $row['id_ujian']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="radio" class="stars" name="pil1" <?php echo ($editRow['pilihan']=='pil1')?'Checked':'' ?> value="pil1"><?php echo ' '.$row['pil1'] ?></td> 
                        </tr>
                        <tr>
                            <td><input type="radio" class="stars" name="pil1" <?php echo ($editRow['pilihan']=='pil2')?'Checked':'' ?> value="pil2"><?php echo ' '.$row['pil2'] ?></td> 
                        </tr>
                        <tr>
                            <td><input type="radio" class="stars" name="pil1" <?php echo ($editRow['pilihan']=='pil3')?'Checked':'' ?> value="pil3"><?php echo ' '.$row['pil3'] ?></td> 
                        </tr>
                        <tr>
                            <td><input type="radio" class="stars" name="pil1" <?php echo ($editRow['pilihan']=='pil4')?'Checked':'' ?> value="pil4"><?php echo ' '.$row['pil4'] ?></td> 
                        </tr>
                    </form>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ada soal....</td>
                </tr>
                <?php
            }

        }

        public function daftarEssay($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            //echo $stmt->rowCount();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $stmt = $this->db->prepare("SELECT * FROM tbl_jawaban_es WHERE id_soal_es=:id_soal_es AND id_ujian=:id_ujian AND id_siswa=:id_siswa");
                    $stmt->execute(array(":id_soal_es"=>$row['id_soal_es'], ":id_ujian"=>$row['id_ujian'], ":id_siswa"=>$row['id_siswa']));
                    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form>
                        <tr>
                            <td>
                                <?php echo $row['soal'] ?>
                                <input type="hidden" id="id_soal_es" value="<?php echo $row['id_soal_es']; ?>">
                                <input type="hidden" id="id_ujian" value="<?php echo $row['id_ujian']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" rows="6" id="jawaban" name="jawaban" required><?php if($editRow['jawaban'] != NULL) {echo $editRow['jawaban'];} ?></textarea>
                            </td> 
                        </tr>
                        <tr>
                            <td>Point : <?php echo $row['poin'] ?></td>
                        </tr>
                    </form>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                <td>Tidak ada soal....</td>
                </tr>
                <?php
            }

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

        public function paginglink3($query,$records_per_page, $id)
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
                // if($current_page!=1)
                // {
                //     $previous =$current_page-1;
                //     echo "<li><a href='".$self."?page_no=1&id=".$id."'>First</a></li>";
                //     echo "<li><a href='".$self."?page_no=".$previous."&id=".$id."'>Previous</a></li>";
                // }
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
                // if($current_page!=$total_no_of_pages)
                // {
                //     $next=$current_page+1;
                //     echo "<li><a href='".$self."?page_no=".$next."&id=".$id."'>Next</a></li>";
                //     echo "<li><a href='".$self."?page_no=".$total_no_of_pages."&id=".$id."'>Last</a></li>";
                // }
                ?></ul><?php
            }
        }

        public function hapusData($table, $id_ujian, $id_siswa) {
            $stmt = $this->db->prepare("DELETE FROM {$table} WHERE id_ujian=:id_ujian AND id_siswa=:id_siswa");
            $stmt->execute(array(":id_ujian"=>$id_ujian, ":id_siswa"=>$id_siswa));
            //$stmt->execute();
            return true;
        }

        public function getLastError() {
            return $this->error;
        }
    }

?>