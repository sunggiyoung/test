<?php
include "./PHPExcel-1.8/Classes/PHPExcel.php";

$objPHPExcel = new PHPExcel();

// 엑셀 데이터를 담을 배열을 선언한다.
$allData = array();

// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
$filename = iconv("UTF-8", "EUC-KR", $_FILES['excelFile']['name']);

try {
    
    // 업로드한 PHP 파일을 읽어온다.
    $objPHPExcel = PHPExcel_IOFactory::load($filename);
    $sheetsCount = $objPHPExcel -> getSheetCount();
    
    // 시트Sheet별로 읽기
    for($sheet = 0; $sheet < $sheetsCount; $sheet++) {
        
        $objPHPExcel -> setActiveSheetIndex($sheet);
        $activesheet = $objPHPExcel -> getActiveSheet();
        $highestRow = $activesheet -> getHighestRow();             // 마지막 행
        $highestColumn = $activesheet -> getHighestColumn();    // 마지막 컬럼
        
        // 한줄읽기
        for($row = 1; $row <= $highestRow; $row++) {
            
            // $rowData가 한줄의 데이터를 셀별로 배열처리 된다.
            $rowData = $activesheet -> rangeToArray("A" . $row . ":" . $highestColumn . $row, NULL, TRUE, FALSE);
            
            // $rowData에 들어가는 값은 계속 초기화 되기때문에 값을 담을 새로운 배열을 선안하고 담는다.
            $allData[$row] = $rowData[0];
        }
    }
} catch(exception $exception) {
    echo $exception;
}

echo "<pre>";
print_r($allData);
echo "</pre>";
?>