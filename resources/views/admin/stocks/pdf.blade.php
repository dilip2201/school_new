<!DOCTYPE html>
<html>
<head>
    <style>
        table, td, th {
            border: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>

<h2>Stocks</h2>

<table>
    <tr>
        <th>Sr No.</th>
        <th>Item</th>
        <th>Vendor</th>
        <th>PO NO.</th>
        <th>Date</th>
        <th>Expected Date</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Pending Quantity</th>
        <th>Remark</th>
        <th>Status</th>
    </tr>
    @if(!empty($stocks))
        @foreach($stocks as $stock)
            @if($stock->status == 'pending')
               <?php $status = 'Pending'; ?>
            @elseif($stock->status == 'ordered')
               <?php $status = 'Ordered'; ?>
            @elseif($stock->status == 'dispatched')
                <?php $status = 'Dispatched'; ?>
            @elseif($stock->status == 'delivered')
               <?php $status = 'Delivered'; ?>
            @elseif($stock->status == 'partially_delivered')
               <?php $status = 'Partially Delivered'; ?>
            @elseif($stock->status == 'cancelled')
               <?php $status = 'Cancelled'; ?>
            @endif
            <tr>
                <td>{{ $stock->id }}</td>
                <td>{{ $stock->item->itemname->name.' ('.$stock->item->name.')' }}</td>
                <td>{{ $stock->vendor ?? 'N/A' }}</td>
                <td>{{ $stock->po_number ?? 'N/A' }}</td>
                <td>{{ (isset($stock->date)) ? date('d M Y',strtotime($stock->date)) : 'N/A' }}</td>
                <td>{{ (isset($stock->expected_date)) ? date('d M Y',strtotime($stock->expected_date)) : 'N/A'  }}</td>
                <td>{{ $stock->itemsize->size ?? '-' }}</td>
                <td>{{ $stock->quantity ?? '0' }}</td>
                <td>{{ $stock->pending_quantity ?? '0' }}</td>
                <td>{{ $stock->remark ?? '' }}</td>
                <td>{{ $status }}</td>
            </tr>
        @endforeach
    @endif
</table>

</body>
</html>
