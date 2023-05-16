<?php

function control($controldata){
    if($controldata==$_POST['adsoyad']){
        if(isset($controldata) && !empty($controldata)){
            if (!preg_match("/^[a-zA-Z ]*$/", $controldata)) {
                echo "Name: Only letters and whitespace allowed";
                return null;
            }else return $controldata;
        }
    }else{
        if(isset($controldata) && !empty($controldata)){
            return $controldata;
        }else{
            return null;
        }
    }
}

try{
    $db=NEW PDO("mysql:host=localhost;dbname=ODEV; charset=utf8","root","",array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

    if(isset($_POST['buton'])){
        $sql="INSERT INTO students SET full_name=?, email=?, gender=?";
        $sonuc=$db->prepare($sql);
          $ad=control($_POST['adsoyad']);
          $posta=control($_POST['eposta']);
          $cinsiyet=$_POST['gender'];
           if ($ad==null || $posta==null) {
               echo "bad data entry";
               exit();
           }else{
               $ekleme=$sonuc->execute([
                   "$ad",
                   "$posta",
                   "$cinsiyet"
               ]);
           }



        if($ekleme){
            echo "<script>alert('data has been inserted click ok and see the database list');</script>";
        }
        else echo "<script>alert('ERROR in insertion!');</script>";
        echo "ÖĞRENCİ LİSTESİ: <br><br><br>";
        $getir_sql="SELECT * FROM students";
        $getir=$db->prepare($getir_sql);
        $getir->execute();
        $data=$getir->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $veri){
            echo "id: ".$veri['id']."<br>";
            echo "fullname: ".$veri['full_name']."<br>";
            echo "email: ".$veri['email']."<br>";
            echo "gender: ".$veri['gender']."<br>";
            echo "------------------------------------<br>";
        }
}
}catch(PDOException $par){
    echo $par->getMessage();
}


