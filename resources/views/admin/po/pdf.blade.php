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

<h2>Purchase Order</h2>

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
