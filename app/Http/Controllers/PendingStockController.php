<?php

namespace App\Http\Controllers;


use App\Stock;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Validator;
use App\Log;
use App\UniformSize;
use Twilio\Rest\Client;
use App\PO;


class PendingStockController extends Controller
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
        return view('admin.pendigstock.index',compact('vendors'));
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
        return view('admin.pendigstock.getmodal', compact('stock','items','sizes'));
    }

    public function loadsize(Request $request){
        $id = $request->item_id;
        $sizes = UniformSize::with('sizeobj')->where('item_id',$id)->orderby('size','asc')->get();
        return view('admin.pendigstock.loadsize',compact('sizes'));
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
        $sizes = array();
        if(!empty($stock->item)){

            $sizes = UniformSize::where('item_id',$stock->item->item_id)->get();
        }
        $items = \DB::table('items')->orderby('id','asc')->get();


        $item_names = \DB::table('item_masters')->where('item_id',$stock->item->item_id)->get();

        return view('admin.stocks.geteditmodal', compact('stock','sizes','items','item_names'));
    }

     /**
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addlog(Request $request)
    {

        $id = $request->id;
        $stock = Stock::where('id',$id)->first();

        return view('admin.pendigstock.getmodallog',compact('stock'));
    }
    public function loadimport(Request $request)
    {
        $ids = array_filter($request->alreadyimported);
        $stocks = Stock::with(['item.itemname','itemsize','vendor','po'])->where('status','pending');
        if(!empty($ids)){
            $stocks = $stocks->whereNotIn('id',$ids);
        }
        $stocks = $stocks->get();
        return view('admin.pendigstock.importstock',compact('stocks'));
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
        $stocks = Stock::with(['item.itemname','itemsize','vendor','po']);
        if (!empty($params['search']['value'])) {
            $value = "%" . $params['search']['value'] . "%";
            $stocks = $stocks->where('remark', 'like', (string)$value);
            $stocks = $stocks->orWhereHas('item.itemname', function($query) use($value) {
                return $query->where('name', 'like', (string)$value);
            } );
            $stocks = $stocks->orWhereHas('vendor', function($query) use($value) {
                return $query->where('name', 'like', (string)$value);
            } );
            $stocks = $stocks->orWhereHas('po', function($query) use($value) {
                return $query->where('po_number', 'like', (string)$value);
            } );
        }
        if (isset($params['order']['0']['column'])) {
            $column = $params['order']['0']['column'];
            if($params['order']['0']['column'] == 0){
                $stocks = $stocks->orderBy('id','desc');    
            }else{
                $stocks = $stocks->orderBy($params['columns'][$column]['data'],$params['order']['0']['dir']);    
            }
            
        }
        if ($request->start_date != ''  && $request->end_date != '') {
            $stocks = $stocks->whereBetween('date',[$request->start_date,$request->end_date]);
        }
        if (isset($request->status) && !empty($request->status)) {
            $stocks = $stocks->whereIn('status',$request->status);
        }else{
        	$stocks = $stocks->whereIn('status',['pending']);
        }
        if (isset($request->vendor_id) && $request->vendor_id != '') {
            $stocks = $stocks->where('vendor_id',$request->vendor_id);
        }

        $userCount = $stocks->count();
        $stocks = $stocks->offset($params['start'])->take($params['length']);
        $stocks = $stocks->get();
        $totalRecords = $userCount;
        foreach ($stocks as $row) {
            if($row->status == 'pending'){
                $status = '<button type="button" class="btn btn-warning statusbtn">Pending</button>';
            }  else if($row->status == 'cancelled'){
                $status = '<button type="button" class="btn btn-danger statusbtn">Cancelled</button>';
            }
            $rowData['id'] = $row->id;
            $rowData['item_id'] =$row->item->itemname->name.'('.$row->item->name.')';
            $rowData['image'] = '<a class="showitem" href="'.url('public/uniforms/'.$row->item->image).'"><img class="previewitem" src="'.url('public/uniforms/'.$row->item->image).'" style="height:70px;width:70px;  "/></a>';
            $rowData['vendor_id'] = $row->vendor->name ?? 'N/A';
            $rowData['po_number'] = $row->po->po_number ?? 'N/A';
            $rowData['date'] = date('d M Y',strtotime($row->date));
            $rowData['expected_date'] = $row->expected_date ?? 'N/A';
            $rowData['size'] = $row->itemsize->size;
            $rowData['quantity'] = $row->quantity;
            $rowData['pending_quantity'] = $row->pending_quantity;
            if(!empty($row->reminder_date)){
                $rem = date('d M Y',strtotime($row->reminder_date)).' '.$row->reminder_time.'<br>'.$row->reminder_remarks;
            }else{
                $rem = '-';
            }
            $rowData['reminder'] = $rem;
            $rowData['remark'] = $row->remark;
            $rowData['status'] = $status;

            $action = '';
            if($row->status != 'cancelled'){
            $action .= '<a title="Edit"  data-id="'.$row->id.'"   data-toggle="modal" data-target=".edit_modal" class="btn btn-info btn-sm openedtmodal" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i> </a> ';
            }
            $action .= '<a title="Logs" data-id="'.$row->id.'" data-toggle="modal" data-target=".history_log" class="btn btn-info btn-sm history_log_show" href="javascript:void(0)"><i class="fa fa-history" aria-hidden="true"></i></a> ';

            $action .= '<a title="Send to vendor" data-id="'.$row->id.'" class="btn btn-info btn-sm sendtovendor" href="javascript:void(0)"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>';

            $action .= ' <a title="Reminder" data-reminder_date="'.$row->reminder_date.'" data-reminder_time="'.$row->reminder_time.'" data-reminder_remarks="'.$row->reminder_remarks.'" data-id="'.$row->id.'" class="btn btn-info btn-sm reminderclick" href="javascript:void(0)"><i class="fa fa-bell" aria-hidden="true"></i></a>';
            
            /*if($row->status != 'cancelled'){
                $action .= ' <a title="Cancel Stock" data-id="'.$row->id.'"  class="btn btn-danger btn-sm caclestock" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>';
            }*/
            $rowData['action'] = $action;
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
     * Get model for add edit user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getmodalhistory(Request $request)
    {
        $histories = Log::where('stock_id',$request->id)->orderBy('created_at','desc')->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
        return view('admin.stocks.historyshow',compact('histories'));
    }

    public function sendorder(Request $request){
        $input = $request->all();
        if(isset($input['id']) && !empty($input['id'])){
            try {
                $msg = "Stock send successfully.";
                $stocks =Stock::whereIn('id',$input['id'])->get();
                $vendor = Vendor::where('id',$request->vendor_id)->first();
                $vendornumber = '';
                if(!empty($vendor)){
                    $vendornumber = $vendor->whatsapp_no;
                }

                if(empty($vendornumber)){
                    $arr = array("status" => 400, "msg" => "Vendor whatsapp number is not exist.", "result" => array());    
                }else {

                    if(!empty($stocks)){
                        foreach ($stocks as $stock) {
                            $orders[$stock->item_id][] = array('size'=>getsize($stock->size),'qty'=>$stock->quantity,'url'=>url('public/uniforms/'.$stock->item->image));
                        }
                        $sid = config('constants.sid');
                        $token = config('constants.token');
                        $twilio = new Client($sid, $token);
                
                        if(!empty($orders)){
                            foreach ($orders as $order) {

                                usort($order, function ($item1, $item2) {
                                    return $item1['size'] <=> $item2['size'];
                                });
                                $body = "Checking availability \n";
                                if(!empty($order)){
                                    foreach ($order as $media) {
                                       $MediaUrl = $media['url'];
                                       $body .= $media['size']." ";
                                    }
                                }

                                $body .= "\n";
                                if(!empty($order)){
                                    foreach ($order as $media) {
                                       
                                       $body .= $media['qty']." ";
                                    }
                                }

                               
                                $message = $twilio->messages->create("whatsapp:".$vendornumber, // to
                                       [
                                           "from" => "whatsapp:+14155238886", //from
                                           "body" => $body,
                                           "MediaUrl" => $MediaUrl
                                       ]
                                );
                                

                            }
                        }
                    }
                }

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
        }else{
            $arr = array("status" => 400, "msg" => "Please select at least one stock to send", "result" => array());
        }
        
        return \Response::json($arr);

    }

    public function sendorderimage(Request $request){
        $input = $request->all();
        if(isset($input['id']) && !empty($input['id'])){
            try {
                $msg = "Item image send successfully.";
                
                $vendor = Vendor::where('id',$request->vendor_id)->first();
                
                $vendornumber = '';
                if(!empty($vendor)){
                    $vendornumber = $vendor->whatsapp_no;
                }

                if(empty($vendornumber)){
                    $arr = array("status" => 400, "msg" => "Vendor whatsapp number is not exist.", "result" => array());    
                }else {
                    $item = \DB::table('item_masters')->whereIn('id',$request->id)->first();
                    if(!empty($item)){
                        $sid = config('constants.sid');
                        $token = config('constants.token');
                        $twilio = new Client($sid, $token);
                        $message = $twilio->messages->create("whatsapp:".$vendornumber, // to
                               [
                                   "from" => "whatsapp:+14155238886", //from
                                   "body" => '',
                                   "MediaUrl" => url('public/uniforms/'.$item->image)
                               ]
                        );
                    }
                }

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
        }else{
            $arr = array("status" => 400, "msg" => "Please select at least one stock to send", "result" => array());
        }
        
        return \Response::json($arr);

    }
    public function cancleorder(Request $request){
        $input = $request->all();
        if(isset($input['id']) && !empty($input['id'])){
            try {
                $msg = "Stock Cancelled successfully.";
                Stock::whereIn('id',$input['id'])->update(['status'=>'cancelled']);
                foreach ($input['id'] as $id) {
                    $log = new Log;
                    $log->stock_id = $id;
                    $log->status = 'cancelled';
                    $log->received_qty = 0;
                    $log->remarks = $request->remark;
                    $log->save();
                }


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
        }else{
            $arr = array("status" => 400, "msg" => "Please select at least one stock to cancle", "result" => array());
        }
        
        return \Response::json($arr);

    }
     public function caclestock($id){
        try {
            $msg = "PO Cancelled successfully.";
            
            $po = PO::with('stocks')->where('id',$id)->first();
            if(!empty($po->stocks)){
                foreach ($po->stocks as $stock) {
                    
                    Stock::where('id',$stock->id)->update(['status'=>'cancelled']);

                    $log = new Log;
                    $log->stock_id = $stock->id;
                    $log->status = 'cancelled';
                    $log->received_qty = 0;
                    $log->remarks = null;
                    $log->save();
                }
            }

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
        return \Response::json($arr);

    }
    public function destroy($id){
        try {
            $msg = "Size deleted successfully.";
            UniformSize::where('id',$id)->delete();
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
        return \Response::json($arr);

    }
    public function addsize(Request $request)
    {

        $rules = [
            'size' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "result" => array());
        } else {
            try {

                $count = UniformSize::where('item_id',$request->item_id)->where('size',$request->size)->count();

                if($count == 0){
                    $us = new UniformSize;
                    $us->item_id = $request->item_id;
                    $us->size = $request->size;
                    $us->save();
                    $msg = "Size added successfully.";
                    $arr = array("status" => 200, "msg" => $msg);
                }else{
                    $msg = "Size is already added for this item.";    
                    $arr = array("status" => 400, "msg" => $msg);
                }
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

    public function storereminder(Request $request)
    {

       
            try {
                Stock::where('id',$request->stock_id)->update(['reminder_date'=>$request->reminder_date,'reminder_time'=>$request->reminder_time,'reminder_remarks'=>$request->reminder_remarks]);
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
        

        return \Response::json($arr);
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
                    $stock->expected_date = $request->expected_date;
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

                            $log = new Log;
                            $log->stock_id = $nstock->id;
                            $log->status = 'pending';
                            $log->received_qty = $stock['quantity'];
                            $log->remarks = null;
                            $log->save();
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

    public function storelog(Request $request)
    {


            try {



                $log = new Log;
                $log->stock_id = $request->stock_id;
                $log->status = $request->status;
                $log->received_qty = $request->received_qty ?? 0;
                $log->remarks = $request->remark;
                $log->save();

                $nstock = Stock::find($request->stock_id);

                if($request->status == 'delivered'){
                    $nstock->pending_quantity = 0;
                }else{
                    $nstock->pending_quantity = $nstock->pending_quantity - $request->received_qty;
                }

                if($request->status == 'partially_delivered'){
                    $nstock->expected_date = $request->expected_date;   
                }
                $nstock->status = $request->status;
                $nstock->save();

                $msg = "Log added successfully.";
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


        return \Response::json($arr);
    }


    /**
     * Export Excel stocks
     * @param Request $request
     * @return mixed
     */
    public function export(Request $request)
    {
        $stocks = Stock::with(['item.itemname','itemsize','po','vendor']);
        if ($request->start_date != ''  && $request->end_date != '') {
            $stocks = $stocks->whereBetween('date',[$request->start_date,$request->end_date]);
        }
        if (isset($request->status) && !empty($request->status)) {
            $stocks = $stocks->whereIn('status',$request->status);
        }else{
            $stocks = $stocks->whereIn('status',['pending','cancelled']);
        }
        if (isset($request->vendor_id) && $request->vendor_id != '') {
            $stocks = $stocks->where('vendor_id',$request->vendor_id);
        }
        $stocks = $stocks->get();
        if($request->exportto == 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            //Set Column width AUto
            foreach(range('A','I') as $columnID) {
                $sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }

            //Set column Width Manual
            $sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(20);

            //Set Column Headings
            $sheet->setCellValue('A1', 'Sr No.');
            $sheet->setCellValue('B1', 'Item');
            $sheet->setCellValue('C1', 'Vendor');
            $sheet->setCellValue('D1', 'PO NO.');
            $sheet->setCellValue('E1', 'Date');
            $sheet->setCellValue('F1', 'Expected Date');
            $sheet->setCellValue('G1', 'Size');
            $sheet->setCellValue('H1', 'Quantity');
            $sheet->setCellValue('I1', 'Pending Quantity');
            $sheet->setCellValue('J1', 'Remark');
            $sheet->setCellValue('K1', 'Status');
            // Set Row Data
            $status = '';
            $rowno = 2;
            foreach ($stocks as $row) {
                if($row->status == 'pending'){
                    $status = 'Pending';
                } else if($row->status == 'ordered'){
                    $status = 'Ordered';
                } else if($row->status == 'dispatched'){
                    $status = 'Dispatched';
                } else if($row->status == 'delivered'){
                    $status = 'Delivered';
                } else if($row->status == 'partially_delivered'){
                    $status = 'Partially Delivered';
                } else if($row->status == 'cancelled'){
                    $status = 'Cancelled';
                }
                $sheet->setCellValue('A' . $rowno, $row->id);
                $sheet->setCellValue('B' . $rowno, $row->item->itemname->name.' ('.$row->item->name.')' ?? 'N/A');
                $sheet->setCellValue('C' . $rowno, $row->vendor->name ?? 'N/A');
                $sheet->setCellValue('D' . $rowno, $row->po->po_number ?? 'N/A');
                $sheet->setCellValue('E' . $rowno, (isset($row->date)) ? date('d M Y',strtotime($row->date)) : 'N/A');
                $sheet->setCellValue('F' . $rowno, (isset($row->expected_date)) ? date('d M Y',strtotime($row->expected_date)) : 'N/A');
                $sheet->setCellValue('G' . $rowno, $row->itemsize->size ?? '-');
                $sheet->setCellValue('H' . $rowno, $row->quantity ?? '0');
                $sheet->setCellValue('I' . $rowno, $row->pending_quantity ?? '0');
                $sheet->setCellValue('J' . $rowno, $row->remark ?? '');
                $sheet->setCellValue('K' . $rowno,  $status);
                $rowno++;
            }
            $fileName = "Stocks.xlsx";
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
            $pdf->loadview('admin.stocks.pdf',compact('stocks','request'));
            return $pdf->download();
        }
        if($request->exportto == 'png') {
//            $im = ImageCreate(200,200);
//            $white = ImageColorAllocate($im,0xFF,0xFF,0xFF);
//            $black = ImageColorAllocate($im,0x00,0x00,0x00);
//            ImageFilledRectangle($im,50,50,150,150,$black);
//            header('Content-Type: image/png');
//            $img = ImagePNG($im);
//            return '<img src="'.$img.'"/>';
        }

    }

}
