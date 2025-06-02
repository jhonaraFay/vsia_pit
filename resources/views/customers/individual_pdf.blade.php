<!DOCTYPE html>
<html>
<head>
    <title>Customer Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; margin-bottom: 20px; }
        .info { margin: 0 30px; }
        .label { font-weight: bold; }
        p { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Customer Report</h1>

    <div class="info">
        <p><span class="label">ID:</span> {{ $customer->id }}</p>
        <p><span class="label">Name:</span> {{ $customer->name }}</p>
        <p><span class="label">Email:</span> {{ $customer->email }}</p>
        <!-- Add more fields if you have -->
    </div>
</body>
</html>
