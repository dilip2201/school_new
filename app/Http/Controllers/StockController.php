<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class StockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::get();
        return view('admin.stocks.index',compact('vendors'));
    }


     /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodal(Request $request)
    {
        $stock = array();
        if (isset($request->id) && $request->id != '') {
            $id = $request->id;
            $stock = Stock::where('id',$id)->first();
        }
        $items = \DB::table('items')->orderby('id','asc')->get();
        $sizes = \DB::table('size')->orderby('id','asc')->get();
        return view('admin.stocks.getmodal', compact('stock','items','sizes'));
    }

    /**
     * Get all the Stocks
     * @param Request $request
     * @return mixed
     */
    public function getall(Request $request)
    {
        $status = '';
        $params = $columns = $totalRecords = $data = array();
        $params = $request;
        $stocks = Stock::with(['item.itemname','itemsize',]);
        if (!empty($params['search']['value'])) {
            $value = "%" . $params['search']['value'] . "%";
            $stocks = $stocks->where('item_id', 'like', (string)$value);
        }
        if (isset($params['order']['0']['column'])) {
            $column = $params['order']['0']['column'];
            $stocks = $stocks->orderBy($params['columns'][$column]['data'],$params['order']['0']['dir']);
        }
        if ($request->start_date != ''  && $request->end_date != '') {
            $stocks = $stocks->whereBetween('date',[$request->start_date,$request->end_date]);
        }
        if (isset($request->status) && !empty($request->status)) {
            $stocks = $stocks->whereIn('status',$request->status);
        }
        $userCount = $stocks->count();
        $stocks = $stocks->offset($params['start'])->take($params['length']);
        $stocks = $stocks->get();
        $totalRecords = $userCount;
        foreach ($stocks as $row) {
            if($row->status == 'pending'){
                $status = '<button type="button" class="btn btn-warning statusbtn">Pending</button>';
            } else if($row->status == 'ordered'){
                $status = '<button type="button" class="btn btn-primary statusbtn">Ordered</button>';
            } else if($row->status == 'dispatched'){
                $status = '<button type="button" class="btn btn-info statusbtn">Dispatched</button>';
            } else if($row->status == 'delivered'){
                $status = '<button type="button" class="btn btn-success statusbtn">Delivered</button>';
            } else if($row->status == 'partially_delivered'){
                $status = '<button type="button" class="btn btn-warning statusbtn">Partially Delivered</button>';
            } else if($row->status == 'cancelled'){
                $status = '<button type="button" class="btn btn-danger statusbtn">Cancelled</button>';
            }
            $rowData['id'] = $row->id;
            $rowData['item_id'] =$row->item->itemname->name.'('.$row->item->name.')';
            $rowData['image'] = '<img src="'.url('public/uniforms/'.$row->item->image).'" style="height:80px;width:80px;  "/>';
            $rowData['vendor_id'] = 'N/A';
            $rowData['po_number'] = 'N/A';
            $rowData['date'] = date('d M Y',strtotime($row->date));
            $rowData['expected_date'] = $row->expected_date ?? 'N/A';
            $rowData['size'] = $row->itemsize->size;
            $rowData['quantity'] = $row->quantity;
            $rowData['pending_quantity'] = $row->pending_quantity;
            $rowData['remark'] = $row->remark;
            $rowData['status'] = $status;
            $rowData['action'] = $row->status;
            $data[] = $rowData;
        }
        $json_data = array(
            "draw" => $params['draw'],
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data   // total data array
        );
        return json_encode($json_data);

    }

        /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'date' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {



                if(!empty($request->stock)){
                    foreach ($request->stock as $stock) {

                        $nstock = new Stock;
                        $nstock->item_id = $request->item_name;
                        $nstock->date = date('Y-m-d',strtotime($request->date));
                        $nstock->size = $stock['size'];
                        $nstock->quantity = $stock['quantity'];
                        $nstock->pending_quantity = $stock['quantity'];
                        $nstock->remark = $stock['remark'];
                        $nstock->status = 'pending';
                        $nstock->save();
                    }
                }
                /*if (isset($request->vendorid)) {
                    $vendor = Vendor::find($request->vendorid);
                    $msg = "Vendor updated successfully.";
                }else{
                    $vendor = new Vendor;
                    $msg = "Vendor added successfully.";
                }
                if ($request->hasFile('image')) {
                    $destinationPath = public_path().'/company/vendor';
                    $file = $request->image;
                    $fileName1 = time().'.'.rand() . '.'.$file->clientExtension();
                    $file->move($destinationPath, $fileName1);
                    $vendor->image = $fileName1;
                }
                $vendor->name = $request->name;
                $vendor->email = $request->email;
                $vendor->phone = str_replace(' ', '', $request->phone);
                $vendor->save();*/

                $msg = "Stock added successfully.";
                $arr = array("status" => 200, "msg" => $msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])) :
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, "result" => array());
            }
        }

        return \Response::json($arr);
    }

    /**
     * Export Excel stocks
     * @param Request $request
     * @return mixed
     */
    public function exportToExcel(Request $request)
    {

        $stocks = Stock::with(['item.itemname','itemsize',]);
        if ($request->start_date != ''  && $request->end_date != '') {
            $stocks = $stocks->whereBetween('date',[$request->start_date,$request->end_date]);
        }
        if (isset($request->status) && !empty($request->status)) {
            $stocks = $stocks->whereIn('status',$request->status);
        }
        if (isset($request->vendor_id) && $request->vendor_id != '') {
            $stocks = $stocks->where('vendor_id',$request->vendor_id);
        }
        $stocks = $stocks->get();
        echo '<pre>';
        print_r($stocks->toArray());
        exit;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //Set Column width AUto
         foreach(range('A','J') as $columnID) {
             $sheet->getColumnDimension($columnID)
                 ->setAutoSize(true);
         }
        //Set column Width Manual
//        $sheet->getColumnDimension('A')->setWidth(16);
//        $sheet->getColumnDimension('B')->setWidth(9);
//        $sheet->getColumnDimension('C')->setWidth(13);
//        $sheet->getColumnDimension('D')->setWidth(22);
//        $sheet->getColumnDimension('E')->setWidth(20);
//        $sheet->getColumnDimension('F')->setWidth(24);
//        $sheet->getColumnDimension('G')->setWidth(24);
//        $sheet->getColumnDimension('H')->setWidth(24);
//        $sheet->getColumnDimension('I')->setWidth(28);
//        $sheet->getColumnDimension('J')->setWidth(22);
        $rows = [
            [
                'voucherdate' => '01-01-2020',
                'vouchernumber' => '123',
                'description' => 'Rent jan-mar',
                'crossaccount' => '6300',
                'accountname' => 'Rent',
                'periodfrom' => '01-01-2020',
                'periodto' => '01-03-2020',
                'original_amount' => '15000',
                'accumulated_accrual_balance' => '5000',
                'remaining_amount' => '10000',
            ]
        ];


        //Set Column Headings
        $sheet->setCellValue('A9', 'Sr No.');
        $sheet->setCellValue('B9', 'Item');
        $sheet->setCellValue('C9', 'Description');
        $sheet->setCellValue('D9', 'Crossaccount');
        $sheet->setCellValue('E9', 'Accountname');
        $sheet->setCellValue('F9', 'Period from');
        $sheet->setCellValue('G9', 'Period to');
        $sheet->setCellValue('H9', 'Original amount');
        $sheet->setCellValue('I9', 'Accumulated accrual balance');
        $sheet->setCellValue('J9', 'Remaining amount');
        // Set Row Data
        $rowno = 10;
        foreach ($rows as $row) {
            $sheet->setCellValue('A' . $rowno, $row['voucherdate']);
            $sheet->setCellValue('B' . $rowno, $row['vouchernumber']);
            $sheet->setCellValue('C' . $rowno, $row['description']);
            $sheet->setCellValue('D' . $rowno, $row['crossaccount']);
            $sheet->setCellValue('E' . $rowno, $row['accountname']);
            $sheet->setCellValue('F' . $rowno, $row['periodfrom']);
            $sheet->setCellValue('G' . $rowno, $row['periodto']);
            $sheet->setCellValue('H' . $rowno, $row['original_amount']);
            $sheet->setCellValue('I' . $rowno, $row['accumulated_accrual_balance']);
            $sheet->setCellValue('J' . $rowno, $row['remaining_amount']);
            $rowno++;
        }
        $sumrow = $rowno + 7;
        $endsum = $sumrow + 2;
        $balencebox = $sumrow + 1;
        $deviationbox = $sumrow + 2;
        $commentsheading = $endsum + 2;

        $sheet->setCellValue('I' . $sumrow, 'Sum');
        $sheet->setCellValue('I' . $balencebox, 'Balance Ledger');
        $sheet->setCellValue('I' . $deviationbox, 'Deviation');

        $styleArray1 = array(
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );
        $styleArray2 = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );

        $range = 'J2:J'.$rowno;
        $info = $rowno + 1;
        $sheet->setCellValue('J'.$sumrow , '=SUM('.$range.')');
        $sheet->setCellValue('J'.$balencebox , '=SUM('.$range.')');
        $sheet->setCellValue('A'.$commentsheading , 'Comments :');
//         $sheet->setCellValue('A'.$info , 'Note: Column A to D and F to H from row 10 will be manual in version 1');
//         $sheet->getStyle('A'.$info)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        $sheet->mergeCells('A'.$info.':D'.$info);
        $sheet->mergeCells('A'.$commentsheading.':J'.$commentsheading);

        $commentstrt = $commentsheading - 1;
        $commentbodystart = $commentsheading + 1;
        $commentbodyend = $commentsheading + 4;
        $sheet->mergeCells('A'.$commentbodystart.':J'.$commentbodyend);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $path = public_path('Centiga-logo-black.png');
        $drawing->setPath($path);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($sheet);
        $center = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1')->applyFromArray($center);

        $sheet->getStyle('J'.$sumrow.':J'.$sumrow)->applyFromArray($styleArray1);
        $sheet->getStyle('J'.$deviationbox.':J'.$deviationbox)->applyFromArray($styleArray1);
        $sheet->getStyle('J'.$balencebox.':J'.$balencebox)->applyFromArray($styleArray1);
        $sheet->getStyle('A'.$commentsheading.':J'.$commentsheading)->applyFromArray($styleArray2);

        // Header Portion
        $sheet->mergeCells('A1:C3');
        $sheet->mergeCells('D1:E1');
        $sheet->mergeCells('D2:E2');
        $sheet->mergeCells('D3:E3');
        $sheet->mergeCells('D4:E4');
        $sheet->mergeCells('D5:E5');
        $sheet->mergeCells('A6:B6');
        $sheet->mergeCells('A7:B7');
        $sheet->getStyle('D1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e0e0e0');
        $sheet->getStyle('D2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        $sheet->getStyle('D3:H3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e0e0e0');
        $sheet->getStyle('D4:H4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        $sheet->getStyle('D5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        $sheet->getStyle("F1:H4")->getFont()->setBold( true );
        $sheet->getStyle("A9:J9")->getFont()->setBold( true );
        $sheet->getStyle('I'.$sumrow.':I'.$sumrow)->getFont()->setBold( true );
        $sheet->getStyle('I'.$balencebox.':I'.$balencebox)->getFont()->setBold( true );
        $sheet->getStyle('I'.$deviationbox.':I'.$deviationbox)->getFont()->setBold( true );
        $sheet->setCellValue('D1' , 'Client name:');
        $sheet->setCellValue('D2' , 'Companyname AS');
        $sheet->setCellValue('F1' , 'Created By:');
        $sheet->setCellValue('F2' , 'DL');
        $sheet->setCellValue('G1' , 'Created Date:');
        $sheet->setCellValue('G2' , '01-11-2020');
        $sheet->setCellValue('H1' , 'Reconciled By:');
        $sheet->setCellValue('H2' , '01-11-2020');
        $sheet->setCellValue('D3' , 'Client No:');
        $sheet->setCellValue('D4' , '11111');
        $sheet->setCellValue('F3' , 'QA by:');
        $sheet->setCellValue('F4' , 'SGS');
        $sheet->setCellValue('G3' , 'QA date:');
        $sheet->setCellValue('G4' , '01-11-2020');
        $sheet->setCellValue('H3' , 'Help');
        $sheet->setCellValue('H4' , '?');
        $sheet->setCellValue('D6' , 'Accrual');
        $sheet->setCellValue('D7' , 'Documentation');
        $sheet->setCellValue('A6' , 'Account');
        $sheet->setCellValue('A7' , 'Link to documentation');
        $sheet->setCellValue('C6' , '2960');
        $sheet->setCellValue('A'.$commentbodystart , 'Enter comments here if deviation');
        $sheet->getStyle('A'.$commentstrt.':J'.$commentbodyend)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A'.$commentstrt.':J'.$commentbodyend)->getAlignment()->setVertical('center');
        $sheet->getStyle('I'.$commentbodystart.':I'.$commentbodyend)->getFont()->setBold( true );
        $sheet->getStyle('A1:J8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I'.$sumrow.':I'.$sumrow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I'.$balencebox.':I'.$balencebox)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I'.$deviationbox.':I'.$deviationbox)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D2:G2')->getAlignment()->setVertical('center');
        $sheet->getStyle("D2:E2")->getFont()->setSize(12);
        $sheet->getStyle("D4:E4")->getFont()->setSize(12);
        $sheet->getRowDimension('2')->setRowHeight(17);

        // Listing Portion
        $sheet->getStyle('A9:J9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e0e0e0');
        $sheet->getStyle('A'.$commentstrt.':J'.$commentsheading)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e0e0e0');
        $sheet->getStyle('A'.$sumrow.':I'.$endsum)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e0e0e0');
        $sheet->getStyle('J10:J'.$sumrow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e0e0e0');
        $sheet->getStyle('J'.$balencebox.':J'.$balencebox)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('87ceeb');
        $sheet->getStyle('J'.$deviationbox.':J'.$deviationbox)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90');

        $fileName = "Demo.xlsx";
        $writer = new Xlsx($spreadsheet);
        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="Demo.xlsx"');
        $response->headers->set('Cache-Control','max-age=0');
        return $response;

    }

}
