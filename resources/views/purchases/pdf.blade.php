<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Purchase Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Purchase Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->customer->name }}</td>
                <td>{{ $p->product->name }}</td>
                <td>{{ $p->quantity }}</td>
                <td>{{ $p->total }}</td>
                <td>{{ $p->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Generated by:</strong> {{ $user->name }} ({{ $user->role ?? 'Staff' }})</p>
<p><strong>Date Generated:</strong> {{ now()->format('F d, Y h:i A') }}</p>

</body>
</html>
