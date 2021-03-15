<?php

namespace App\Http\Controllers;

use App\PO;
use App\Stock;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Validator;

class POController extends Controller
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
        return view('admin.po.index',compact('vendors'));
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
        $vendors = \DB::table('vendors')->orderby('id','asc')->get();
        $sizes = \DB::table('size')->orderby('id','asc')->get();
        return view('admin.po.getmodal', compact('stock','vendors','sizes'));
    }


     /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function editmodal(Request $request)
    {
        $id = $request->id;
        $stock = Stock::with(['item.itemname','itemsize'])->where('id',$id)->first();
        $sizes = \DB::table('size')->orderby('id','asc')->get();
        $items = \DB::table('items')->orderby('id','asc')->get();


        $item_names = \DB::table('item_masters')->where('item_id',$stock->item->item_id)->get();

        return view('admin.po.geteditmodal', compact('stock','sizes','items','item_names'));
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
        $pos = PO::with('vendor');
        if (!empty($params['search']['value'])) {
            $value = "%" . $params['search']['value'] . "%";
            $pos = $pos->where('po_number', 'like', (string)$value);
        }
        if (isset($params['order']['0']['column'])) {
            $column = $params['order']['0']['column'];
            $pos = $pos->orderBy($params['columns'][$column]['data'],$params['order']['0']['dir']);
        }
        if ($request->start_date != ''  && $request->end_date != '') {
            $pos = $pos->whereBetween('date',[$request->start_date,$request->end_date]);
        }
        if (isset($request->status) && !empty($request->status)) {
            $pos = $pos->whereIn('status',$request->status);
        }
        if (isset($request->vendor_id) && $request->vendor_id != '') {
            $pos = $pos->where('vendor_id',$request->vendor_id);
        }
        $userCount = $pos->count();
        $pos = $pos->offset($params['start'])->take($params['length']);
        $pos = $pos->get();
        $totalRecords = $userCount;
        foreach ($pos as $row) {
            if($row->status == 'open'){
                $status = '<button type="button" class="btn btn-warning statusbtn">Open</button>';
            } else if($row->status == 'partially_open'){
                $status = '<button type="button" class="btn btn-primary statusbtn">Partially Open</button>';
            } else if($row->status == 'closed'){
                $status = '<button type="button" class="btn btn-info statusbtn">Closed</button>';
            }
            $rowData['id'] = $row->id;
            $rowData['date'] = date('d M Y',strtotime($row->date));
            $rowData['po_number'] = $row->po_number ?? 'N/A';
            $rowData['vendor_id'] = $row->vendor->name ?? 'N/A';
            $rowData['status'] = $status;
            $rowData['action'] = '<a title="Edit"  data-id="'.$row->id.'"   data-toggle="modal" data-target=".edit_modal" class="btn btn-info btn-sm openedtmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> </a>';
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



                if(isset($request->stockid) && $request->stockid > 0){
                    $stock = Stock::find($request->stockid);
                    $stock->item_id = $request->item_name;
                    $stock->date = date('Y-m-d',strtotime($request->date));
                    $stock->size = $request->size;
                    $stock->quantity = $request->quantity;
                    $stock->remark = $request->remark;
                    $stock->save();

                }else{
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
                }


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
    public function export(Request $request)
    {

        $pos = PO::with('vendor');
        if ($request->start_date != ''  && $request->end_date != '') {
            $pos = $pos->whereBetween('date',[$request->start_date,$request->end_date]);
        }
        if (isset($request->status) && !empty($request->status)) {
            $pos = $pos->whereIn('status',$request->status);
        }
        if (isset($request->vendor_id) && $request->vendor_id != '') {
            $pos = $pos->where('vendor_id',$request->vendor_id);
        }
        $pos = $pos->get();
        if($request->exportto == 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            //Set Column width AUto
            foreach(range('A','E') as $columnID) {
                $sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            //Set Column Headings
            $sheet->setCellValue('A1', 'Sr No.');
            $sheet->setCellValue('B1', 'Date');
            $sheet->setCellValue('C1', 'PO NO.');
            $sheet->setCellValue('D1', 'Vendor');
            $sheet->setCellValue('E1', 'Status');
            // Set Row Data
            $status = '';
            $rowno = 2;

            foreach ($pos as $row) {
                if($row->status == 'open'){
                    $status = 'Open';
                } else if($row->status == 'partially_open'){
                    $status = 'Partially Open';
                } else if($row->status == 'closed'){
                    $status = 'Closed';
                }
                $sheet->setCellValue('A' . $rowno, $row->id);
                $sheet->setCellValue('B' . $rowno, (isset($row->date)) ? date('d M Y',strtotime($row->date)) : 'N/A');
                $sheet->setCellValue('C' . $rowno, $row->po_number ?? 'N/A');
                $sheet->setCellValue('D' . $rowno, $row->vendor->name ?? 'N/A');
                $sheet->setCellValue('E' . $rowno,  $status);
                $rowno++;
            }
            $fileName = "po.xlsx";
            $writer = new Xlsx($spreadsheet);
            $response =  new StreamedResponse(
                function () use ($writer) {
                    $writer->save('php://output');
                }
            );
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition', 'attachment;filename="'.$fileName.'"');
            $response->headers->set('Cache-Control','max-age=0');
            return $response;
        }
        if($request->exportto == 'pdf') {

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadview('admin.po.pdf',compact('pos'));
            return $pdf->stream();
        }
        if($request->exportto == 'png') {


                //Let's generate a totally random string using md5
                $md5 = md5(rand(0, 999));

                //We don't need a 32 character long string so we trim it down to 5
                $pass = substr($md5, 10, 5);

                //Set the image width and height
                $width = 100;
                $height = 20;

                //Create the image resource
                $image = ImageCreate($width, $height);

                //We are making three colors, white, black and gray

                $white = ImageColorAllocate($image, 255, 255, 255);

                $black = ImageColorAllocate($image, 0, 0, 0);

                $grey = ImageColorAllocate($image, 204, 204, 204);

                //Make the background black
                ImageFill($image, 0, 0, $black);

                //Add randomly generated string in white to the image
                ImageString($image, 3, 30, 3, $pass, $white);

                //Throw in some lines to make it a little bit harder for any bots to break
                ImageRectangle($image, 0, 0, $width - 1, $height - 1, $grey);

                imageline($image, 0, $height / 2, $width, $height / 2, $grey);

                imageline($image, $width / 2, 0, $width / 2, $height, $grey);

                //Tell the browser what kind of file is come in
                header("Content-Type: image/jpeg");

                //Output the newly created image in jpeg format
                ImageJpeg($image);

                //Free up resources
                ImageDestroy($image);

        }

    }
}
