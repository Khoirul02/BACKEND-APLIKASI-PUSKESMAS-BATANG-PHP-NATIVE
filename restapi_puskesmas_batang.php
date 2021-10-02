<?php
require_once "config.php";
   if(function_exists($_GET['function'])) {
         $_GET['function']();
      }   
   function get_dokter()
   {
      global $connect;      
      $query = $connect->query("SELECT * FROM dokter");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Success',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }

   function get_poli()
   {
      global $connect;      
      $query = $connect->query("SELECT * FROM poli");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Success',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
   
   function login_pasien()
   {
      global $connect;
      $check = array('nohp'=>'','tgl_lahir'=>'');
         $check_match = count(array_intersect_key($_POST, $check));         
         if($check_match == count($check)){
              $query = mysqli_query($connect, "SELECT * FROM pasien WHERE nohp = '$_POST[nohp]' AND tgl_lahir= '$_POST[tgl_lahir]'");
              $check_data = mysqli_num_rows($query); 
              if($check_data > 0){
                while($row=mysqli_fetch_object($query))
                {
                   $data[] =$row;
                }
                $response = array(
                    'status' => 1,
                    'message' =>'Login Success',
                    'data' => $data
                );
              }else{
                $response=array(
                    'status' => 0,
                    'message' =>'Login Failed'
                );
              }
         }else{
            $response=array(
                'status' => 0,
                'message' =>'Wrong Parameter',
                'data'=> $username_akun
             );
         }
        header('Content-Type: application/json');
        echo json_encode($response);
   }
   function insert_pasien()
      {
         global $connect;   
         $check = array('nama'=>'','no_kk'=>'','nik'=>'' ,'nohp'=>'','tgl_lahir'=>'','jenkel'=>'','alamat'=>'');
         $check_match = count(array_intersect_key($_POST, $check));
         if($check_match == count($check)){
         
               $result = mysqli_query($connect, "INSERT INTO pasien SET
               nama = '$_POST[nama]',
               no_kk = '$_POST[no_kk]',
               nik = '$_POST[nik]',
               nohp = '$_POST[nohp]',
               tgl_lahir = '$_POST[tgl_lahir]',
               jenkel = '$_POST[jenkel]',
               alamat = '$_POST[alamat]'");
               
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Insert Success'
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Insert Failed.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
     }
     function insert_antrian()
      {
         global $connect;   
         $check = array('id_pasien'=>'','id_poli'=>'');
         $check_match = count(array_intersect_key($_POST, $check));
         if($check_match == count($check)){
               $tgl = date('Y-m-d');
               $query_antrian_poli = mysqli_query($connect,"SELECT * FROM antrian WHERE id_poli= '$_POST[id_poli]' AND create_at like '$tgl%'");
               $total_antrian_poli = mysqli_num_rows($query_antrian_poli);
               $antrian_selanjutnya = $total_antrian_poli + 1;
               $result = mysqli_query($connect, "INSERT INTO antrian SET
               id_pasien='$_POST[id_pasien]' ,
	            id_poli='$_POST[id_poli]' ,
	            no_antrian='$antrian_selanjutnya'
               ");
               
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Insert Success'
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Insert Failed.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }

      function get_antrian_id_pasien()
      {
         global $connect;
         $check = array('id_pasien'=>'');
         $check_match = count(array_intersect_key($_POST, $check));         
         if($check_match == count($check)){      
            $query = $connect->query("SELECT * FROM antrian INNER JOIN pasien ON pasien.id = antrian.id_pasien INNER JOIN poli ON poli.id = antrian.id_poli WHERE antrian.id_pasien ='$_POST[id_pasien]'");            
            while($row=mysqli_fetch_object($query))
            {
               $data[] =$row;
            }
            $response=array(
                           'status' => 1,
                           'message' =>'Success',
                           'data' => $data
                        );
            header('Content-Type: application/json');
            echo json_encode($response);
         }
      }
      function get_antrian_id_pasien_and_date()
      {
         global $connect;
         $check = array('id_pasien'=>'');
         $check_match = count(array_intersect_key($_POST, $check));         
         if($check_match == count($check)){
            $tgl = date('Y-m-d');      
            $query = $connect->query("SELECT * FROM antrian INNER JOIN pasien ON pasien.id = antrian.id_pasien INNER JOIN poli ON poli.id = antrian.id_poli WHERE antrian.id_pasien ='$_POST[id_pasien]' AND antrian.create_at like '$tgl%'");            
            while($row=mysqli_fetch_object($query))
            {
               $data[] =$row;
            }
            $response=array(
                           'status' => 1,
                           'message' =>'Success',
                           'data' => $data
                        );
            header('Content-Type: application/json');
            echo json_encode($response);
         }
      }
 ?>