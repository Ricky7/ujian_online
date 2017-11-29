<?php

    class Admin {

        private $db; 
        private $error; 

        function __construct($db_conn) {

            $this->db = $db_conn;

            // Mulai session
            session_start();
        }

        public function getDataByID($table, $field, $id) {

            $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE {$field}=:id");
            $stmt->execute(array(":id"=>$id));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function getSiswaByID($id) {

            $stmt = $this->db->prepare("SELECT * FROM tbl_siswa INNER JOIN tbl_kelas INNER JOIN tbl_jurusan ON (tbl_siswa.id_kelas=tbl_kelas.id_kelas) AND (tbl_siswa.id_jurusan=tbl_jurusan.id_jurusan) WHERE tbl_siswa.id_siswa=:id");
            $stmt->execute(array(":id"=>$id));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function getMapelByID($id) {

            $stmt = $this->db->prepare("SELECT * FROM tbl_mapel WHERE id_mapel=:id");
            $stmt->execute(array(":id"=>$id));
            $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
            return $editRow;
        }

        public function getJurusan() {

            try {
                // Ambil data kategori dari database
                $query = $this->db->prepare("SELECT * FROM tbl_jurusan");
                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function getMapel() {

            try {
                // Ambil data kategori dari database
                $query = $this->db->prepare("SELECT * FROM tbl_mapel");
                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function getKelas() {

            try {
                // Ambil data kategori dari database
                $query = $this->db->prepare("SELECT * FROM tbl_kelas");
                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function getGuru() {

            try {
                // Ambil data kategori dari database
                $query = $this->db->prepare("SELECT * FROM tbl_guru");
                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function login($username, $password)
        {
            try
            {
                // Ambil data dari database
                $query = $this->db->prepare("SELECT * FROM tbl_admin WHERE username = :username");
                $query->bindParam(":username", $username);
                $query->execute();
                $data = $query->fetch();

                // Jika jumlah baris > 0
                if($query->rowCount() > 0){
                    // jika password yang dimasukkan sesuai dengan yg ada di database
                    if(password_verify($password, $data['password'])){
                        $_SESSION['user_session'] = $data['id_admin'];
                        $_SESSION['user_role'] = $data['role'];
                        return true;
                    }else{
                        $this->error = "Username atau Password Salah";
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

        // Cek apakah Admin sudah login
        public function isAdminLoggedIn(){
            // Apakah user_session sudah ada di session
            if(isset($_SESSION['user_session']))
            {
                if($_SESSION['user_role'] == 'admin') 
                {
                    return true;
                }
            }
        }

        public function cekLogin() {

            if(!self::isAdminLoggedIn()){
                header("location: admin_login.php");
            }
        }

        // Ambil data admin yang sudah login
        public function getAdmin(){
            // Cek apakah sudah login
            if(!$this->isAdminLoggedIn()){
                return false;
            }

            try {
                // Ambil data Pengurus dari database
                $query = $this->db->prepare("SELECT * FROM tbl_admin WHERE id_admin = :id");
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

            $cek = "SELECT password FROM tbl_admin WHERE id_admin=:id";
            $stmt = $this->db->prepare($cek);
            $stmt->execute(array(":id"=>$id));
            $pass=$stmt->fetch(PDO::FETCH_ASSOC);

            $newPass = password_hash($new, PASSWORD_DEFAULT);

            if($stmt->rowCount()>0) {

                if(password_verify($old, $pass['password'])) {

                    // update new password
                    $new = "UPDATE tbl_admin SET password='{$newPass}' WHERE id_admin={$id}";

                    $stmtC = $this->db->prepare($new);
                    $stmtC->execute();

                    ?>
                        <div class="alert alert-success" style="height:50px;">
                            Berhasil Diubah!
                        </div>
                        <script>
                            setInterval(function() {
                                window.location.href = "admin_password.php";
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
                                window.location.href = "admin_password.php";
                            }, 5000);
                        </script>
                    <?php
                }
            }
            
        }

        public function ubahNama($id, $value) {


            $sql = "UPDATE tbl_admin SET nama='{$value}' WHERE id_admin = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function daftarJurusan($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['id_jurusan']); ?></td>
                        <td><?php print($row['nama_jurusan']); ?></td>
                        <td> 
                        <a href="admin_edit_jur.php?id=<?php print($row['id_jurusan']) ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td>
                        <a href="admin_hapus.php?tb=tbl_jurusan&set=id_jurusan&id=<?php print($row['id_jurusan']) ?>" onclick="return confirm('Hapus data ini?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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

        public function inputData($table, $field, $value) {


            $sql = "INSERT INTO {$table} ($field) VALUES ('{$value}')";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function editMapel($id, $value) {


            $sql = "UPDATE tbl_mapel SET nama_mapel='{$value}' WHERE id_mapel = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function editGuru($fields = array(), $id) {

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

        public function editSiswa($fields = array(), $id) {

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

        public function editUjian($fields = array(), $id) {

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
            $sql = "UPDATE tbl_ujian SET {$set} WHERE id_ujian = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
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

        public function editJurusan($id, $value) {


            $sql = "UPDATE tbl_jurusan SET nama_jurusan='{$value}' WHERE id_jurusan = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function editKelas($id, $value) {


            $sql = "UPDATE tbl_kelas SET nama_kelas='{$value}' WHERE id_kelas = {$id}";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;

        }

        public function daftarKelas($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['id_kelas']); ?></td>
                        <td><?php print($row['nama_kelas']); ?></td>
                        <td> 
                        <a href="admin_edit_kelas.php?id=<?php print($row['id_kelas']) ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td>
                        <a href="admin_hapus.php?tb=tbl_kelas&set=id_kelas&id=<?php print($row['id_kelas']) ?>" onclick="return confirm('Hapus data ini?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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

        public function daftarMapel($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['id_mapel']); ?></td>
                        <td><?php print($row['nama_mapel']); ?></td>
                        <td> 
                        <a href="admin_edit_mapel.php?id=<?php print($row['id_mapel']) ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td>
                        <a href="admin_hapus.php?tb=tbl_mapel&set=id_mapel&id=<?php print($row['id_mapel']) ?>" onclick="return confirm('Hapus data ini?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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

        public function daftarGuru($query) {

            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            if($stmt->rowCount()>0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    ?>

                    <tr>
                        <td><?php print($row['nig']); ?></td>
                        <td><?php print($row['nama']); ?></td>
                        <td><?php print($row['gender']); ?></td>
                        <td> 
                        <a href="admin_edit_guru.php?id=<?php print($row['id_guru']) ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td>
                        <a href="admin_hapus.php?tb=tbl_guru&set=id_guru&id=<?php print($row['id_guru']) ?>" onclick="return confirm('Hapus data ini?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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

        public function daftarSiswa($query) {

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
                        <td><?php print($row['gender']); ?></td>
                        <td><?php print($row['nama_kelas']); ?></td>
                        <td><?php print($row['nama_jurusan']); ?></td>
                        <td> 
                        <a href="admin_edit_siswa.php?id=<?php print($row['id_siswa']) ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td>
                        <a href="admin_hapus.php?tb=tbl_siswa&set=id_siswa&id=<?php print($row['id_siswa']) ?>" onclick="return confirm('Hapus data ini?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
                        <td><?php print($row['nama']); ?></td>
                        <td> 
                        <a href="admin_edit_ujian.php?id=<?php print($row['id_ujian']) ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td>
                        <a href="admin_hapus.php?tb=tbl_ujian&set=id_ujian&id=<?php print($row['id_ujian']) ?>" onclick="return confirm('Hapus data ini?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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

        public function hapusData($table, $field, $id) {
            $stmt = $this->db->prepare("DELETE FROM {$table} WHERE {$field}=:id");
            $stmt->bindparam(":id",$id);
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

        public function getLastError() {
            return $this->error;
        }


    }

?>