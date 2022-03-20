<?php

namespace App\Controllers;
use App\Models\ArticulosModel;
use App\Models\VentasModel;
// use App\ThirdParty\\PhpOffice\PhpSpreadsheet\Spreadsheet;
// CI4\app\ThirdParty\PhpSpreadsheet
// use App\ThirdParty\PhpOffice\PhpSpreadsheet\Spreadsheet;
// use App\ThirdParty\PhpSpreadsheet\Spreadsheet\Spreadsheet;
// use PHPspSheet\PhpSpreadsheet;
// use PhpOffice\PhpSpreadsheet;
// use PHPspSheet\PhpSpreadsheet;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use App\ThirdParty\PhpOffice\PhpSpreadsheet\Spreadsheet;
// use App\ThirdParty\PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Inicio extends BaseController
{
  protected $dataModel;

  public function __construct()
  {
    //   $this->dataModel = new ArticulosModel();
  }

  public function index()
  {
    $session = session();
    if (!isset($session->usuario_id)) 
       return redirect()->to(base_url());
    // return view('tables');
    // $dataHead = [ 
    //    'tabTitle'  => 'Army 5tore - VS',
    //    'brandName' => 'POS - VS',
    // ];
    // $dataFoot = [
    //    'webSite'   => 'Virtual Army 5tore ' . date('Y')

    $this->dataModel = new VentasModel();
    // $data['ventas'] = $this->dataModel->conteoDelDia( '2022-02-21' ); // 2022-02-21
    // $data['ventas'] = $this->dataModel->conteoDelDia( '2022-02-22' ); // 2022-02-22
    // $hoy = '2022-02-21';
    // $hoy = '2022-02-22';
    $hoy = date('Y-m-d');
    $data = $this->dataModel->totalDelDia( $hoy );
    $data['ventas'] = $this->dataModel->conteoDelDia( $hoy );

    $this->dataModel = new ArticulosModel();
    $data['articulos'] = $this->dataModel->total();
    $data['minimos'] = $this->dataModel->minimos();
    // // $this->dataModel = new ArticulosModel();
    // // $data = [ 'total'] = $this->dataModel->total();
    // var_dump($data);
    // return;
    echo view('includes/header');
    // echo view('includes/header', $dataHead);
    // echo view('tables');
    echo view('inicio', $data);
    // echo view('includes/footer', $dataFoot);
    echo view('includes/footer');
  }

  public function excel ()
  {
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    echo "excel";
    return;
    
    $sheet->setCellValue('A1', 'Hello World !');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('hello world.xlsx');

    // require __DIR__ . '/../Header.php';
    
    // $helper->log('Create new Spreadsheet object');
    // $spreadsheet = new \PHPspSheet\Spreadsheet();
    // $spreadsheet = new \PHPspSheet\Spreadsheet();
    $spreadsheet = new \Spreadsheet();
    
   
    // Set document properties
    // $helper->log('Set document properties');
    $spreadsheet->getProperties()
        ->setCreator('Maarten Balliauw')
        ->setLastModifiedBy('Maarten Balliauw')
        ->setTitle('PhpSpreadsheet Test Document')
        ->setSubject('PhpSpreadsheet Test Document')
        ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
        ->setKeywords('office PhpSpreadsheet php')
        ->setCategory('Test result file');
    
    // Add some data
    // $helper->log('Add some data');
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Hello')
        ->setCellValue('B2', 'world!')
        ->setCellValue('C1', 'Hello')
        ->setCellValue('D2', 'world!');
    
    // Miscellaneous glyphs, UTF-8
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A4', 'Miscellaneous glyphs')
        ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
    
    $spreadsheet->getActiveSheet()
        ->setCellValue('A8', "Hello\nWorld");
    $spreadsheet->getActiveSheet()
        ->getRowDimension(8)
        ->setRowHeight(-1);
    $spreadsheet->getActiveSheet()
        ->getStyle('A8')
        ->getAlignment()
        ->setWrapText(true);
    
    $value = "-ValueA\n-Value B\n-Value C";
    $spreadsheet->getActiveSheet()
        ->setCellValue('A10', $value);
    $spreadsheet->getActiveSheet()
        ->getRowDimension(10)
        ->setRowHeight(-1);
    $spreadsheet->getActiveSheet()
        ->getStyle('A10')
        ->getAlignment()
        ->setWrapText(true);
    $spreadsheet->getActiveSheet()
        ->getStyle('A10')
        ->setQuotePrefix(true);
    
    // Rename worksheet
    // $helper->log('Rename worksheet');
    $spreadsheet->getActiveSheet()
        ->setTitle('Simple');
    
    // Save
    // $helper->write($spreadsheet, __FILE__, ['Xlsx', 'Xls', 'Ods']);
  }

}
