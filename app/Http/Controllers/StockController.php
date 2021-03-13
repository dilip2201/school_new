<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('admin.stocks.index');
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
        return view('admin.stocks.getmodal', compact('stock','items'));
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
        $stocks = Stock::with('item');
        if (!empty($params['search']['value'])) {
            $value = "%" . $params['search']['value'] . "%";
            $stocks = $stocks->where('item_id', 'like', (string)$value);
        }
        if (isset($params['order']['0']['column'])) {
            $column = $params['order']['0']['column'];
            $stocks = $stocks->orderBy($params['columns'][$column]['data'],$params['order']['0']['dir']);
        }
        if (isset($request->start_date) && isset($request->end_date)) {

            $stocks = $stocks->whereBetween('date',[$request->end_date,$request->end_date]);
        }
        if (isset($request->status) && $request->status != '') {
            $stocks = $stocks->where('status',$request->status);
        }
        $userCount = $stocks->count();
        $stocks = $stocks->offset($params['start'])->take($params['length']);
        $stocks = $stocks->get();
        $totalRecords = $userCount;
        foreach ($stocks as $row) {
            if($row->status == 'pending'){
                $status = '<button type="button" class="btn btn-secondary statusbtn">Pending</button>';
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
            $rowData['item_id'] = $row->item->name ?? '-';
            $rowData['date'] = $row->date;
            $rowData['expected_date'] = $row->expected_date;
            $rowData['size'] = $row->size;
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


}
