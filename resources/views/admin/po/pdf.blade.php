<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 5px; padding: 15px}
        body { margin: 0px; padding: 15px }
        table, td, th {
            border: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        .container {
            width: 100%;
        }

        .one {
            width: 40%;
            height: 50px;
            float: left;
        }

        .two {
            margin-left: 40%;
            height: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
<section class="container">
    <div class="one">
        <b>Date : </b> @if(isset($request->start_date) && isset($request->end_date)){{ date('d M Y',strtotime($request->start_date)) .' to '. date('d M Y',strtotime($request->end_date)) }} @else All @endif
        <br><b>Vendor : </b> @if(isset($request->vendor_id) && $request->vendor_id != '') {{ $pos[0]->vendor->name ?? 'N/A' }} @else All @endif
    </div>
    <div class="two">
        <b>Status : </b> @if(isset($request->status) && !empty($request->status)) {{ implode(',',$request->status) }} @else All @endif
    </div>
</section>
<table>
    <tr>
        <th>Sr No.</th>
        <th>Date</th>
        <th>PO NO.</th>
        <th>Vendor</th>
        <th>Status</th>
    </tr>
    @if(!empty($pos))
        @foreach($pos as $po)
            @if($po->status == 'open')
                <?php $status = 'Open'; ?>
            @elseif($po->status == 'partiaally_open')
                <?php $status = 'Partially Open'; ?>
            @elseif($po->status == 'closed')
                <?php $status = 'Closed'; ?>
            @endif
            <tr>
                <td>{{ $po->id }}</td>
                <td>{{ (isset($po->date)) ? date('d M Y',strtotime($po->date)) : 'N/A' }}</td>
                <td>{{ $po->po_number ?? 'N/A' }}</td>
                <td>{{ $po->vendor->name ?? 'N/A' }}</td>
                <td>{{ $status }}</td>
            </tr>
        @endforeach
    @endif
</table>

</body>
</html>
