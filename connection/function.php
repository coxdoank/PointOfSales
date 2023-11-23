<?php
//fungsi insert data
function InsertData($table_name, $form_data)
{
    $hostname 		= "localhost";
    $database 		= "db_pos";
    $username 		= "root";
    $password		= "";

    $connection = new mysqli($hostname,$username,$password,$database);

	$field = array_keys($form_data);
	$sql = "insert into ".$table_name." 
	(".implode(",", $field).")
	values ('".implode("','", $form_data)."')";
	// print_r($sql);
	
	return mysqli_query($connection,$sql);
}
//sample insert
//$table_name = "ticket_item";
//	$form_data = array(
//				TERMINAL' => $terminal,
//				ITEM_ID' => $row['ID_MENU_ITEM'],
//				ITEM_COUNT' => 1,
//				ITEM_NAME' => $row['MENU_NAME'],
//				CATEGORY_NAME' => $row['CATEGORY_NAME'],
//				ITEM_PRICE' => $row['PRICE'],
//				DISCOUNT_RATE' => 0,
//				SUB_TOTAL' => $sub_total,
//				DISCOUNT' => 0,
//				TAX_AMOUNT' => 0,
//				TOTAL_PRICE' => $sub_total,
//				NO_TRANSACTION' => $notrans
//				);
//	
//	InsertData($table_name, $form_data);

//fungsi insert data
function InsertInto($table_from, $field_data, $table_to, $where_clause='')
{
    $hostname 		= "localhost";
    $database 		= "db_pos";
    $username 		= "root";
    $password		= "";

    $connection = new mysqli($hostname,$username,$password,$database);

    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }

    $field = array_keys($field_data);
    $sql = "insert into ".$table_from." 
    (".implode(",", $field).")
    select ".implode(",", $field)." from ".$table_to."";

    // append the where statement
    $sql .= $whereSQL;
    // print_r($sql);
    
    return mysqli_query($connection,$sql);
}

//fungsi update data
function UpdateData($table_name, $form_data, $where_clause='')
{
    $hostname 		= "localhost";
    $database 		= "db_pos";
    $username 		= "root";
    $password		= "";

    $connection = new mysqli($hostname,$username,$password,$database);

    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "".$column." = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;
    // print_r($sql);

    // run and return the query result
    return mysqli_query($connection,$sql);
}

//sample updatedata
//	$table_name01 = "ticket";
//	$form_data01 = array(
//				'AMOUNT' => $rwamount['AMOUNT']
//				);
//				
//	UpdateData($table_name01, $form_data01, "WHERE NO_TRANSACTION = '$notrans' and TERMINAL = '$terminal'");	

// the where clause is left optional incase the user wants to delete every row!
function DeleteData($table_name, $where_clause='')
{
    $hostname 		= "localhost";
    $database 		= "db_pos";
    $username 		= "root";
    $password		= "";

    $connection = new mysqli($hostname,$username,$password,$database);

    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;
    // print_r($sql);

    // run and return the query result resource
    return mysqli_query($connection,$sql);
}

//sample delete data
//	$table_name = "ticket";		
//	DeleteData($table_name, " where TERMINAL = '$terminal' and ID_USER = '$user_check' and NO_TRANSACTION = '$notrans'");

function digittodb($var){
    $angka = isset($angka) ? $angka : '';
    $PecahStr = explode(",", $var);
    for ( $i = 0; $i < count($PecahStr); $i++ ) {
    $angka .= $PecahStr[$i];
    }
    $digittodb = $angka;
    return $digittodb;
}

function tujuan($var){
    $kata = isset($kata) ? $kata : '';
    $PecahStr = explode(";", $var);
    for ( $i = 0; $i < count($PecahStr); $i++ ) {
    $kata .= $PecahStr[$i]."<br>";
    }
    $tujuan = $kata;
    return $tujuan;
}

function tglintodb($tgl){
    $array=explode('/',$tgl);
    $bulan=$array[0];
    $tanggal=$array[1];
    $tahun=$array[2];
    $tgl="$tahun-$bulan-$tanggal";
    return $tgl;
}

function tglvwform($tgl){
    $array=explode('-',$tgl);
    $tahun=$array[0];
    $bulan=$array[1];
    $tanggal=$array[2];
    $tgl="$bulan/$tanggal/$tahun";
    return $tgl;
}

function tanggal($tgl){
    $array=explode('-',$tgl);
    $tahun=$array[0];
    $bulan=$array[1];
    $tanggal=$array[2];

    if($bulan == '01'){ $bulan = "Jan"; }
    elseif($bulan == '02'){ $bulan = "Feb"; }
    elseif($bulan == '03'){ $bulan = "Mar"; }
    elseif($bulan == '04'){ $bulan = "Apr"; }
    elseif($bulan == '05'){ $bulan = "Mei"; }
    elseif($bulan == '06'){ $bulan = "Jun"; }
    elseif($bulan == '07'){ $bulan = "Jul"; }
    elseif($bulan == '08'){ $bulan = "Agust"; }
    elseif($bulan == '09'){ $bulan = "Sept"; }
    elseif($bulan == '10'){ $bulan = "Okt"; }
    elseif($bulan == '11'){ $bulan = "Nov"; }
    elseif($bulan == '12'){ $bulan = "Des"; }

    $tgl="$tanggal $bulan $tahun";
    return $tgl;
}

function selisihtgl($tglawal,$tglakhir){
    $tglawal = new DateTime("$tglawal");
    $tglakhir = new DateTime("$tglakhir");
    $interval = $tglawal->diff($tglakhir);
    $interval = $interval->days;
    return $interval;
}

function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . "ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }
        return $temp;
}
 
 
function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}
//sample -> echo terbilang($nilai, $style=1); 

function company($x){
    if($x == 'OTO'){
        $x = "OTO Multiartha";
    }elseif($x == 'SOF'){
        $x = "Summit OTO Finance";
    }
    return $x;
}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
// echo generateRandomString(20)

// Upload File Zip
function UploadZip($fupload_name){
  //direktori favicon di root
  $vdir_upload = "inc/file/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}

?>