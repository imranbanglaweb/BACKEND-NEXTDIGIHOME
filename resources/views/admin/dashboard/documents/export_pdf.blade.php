<!DOCTYPE html>
<html>
<head>
    <title>Documents List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #333;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Documents List</h2>
    </div>
    <div class="date">
        Generated on: {{ date('d M Y') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Project</th>
                <th>Land</th>
                <th>Document</th>
                <th>Taker</th>
                <th>Witness</th>
                <th>Vault #</th>
                <th>Location</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $document)
            <tr>
                <td>{{ $document->id }}</td>
                <td>{{ $document->date->format('d-m-Y') }}</td>
                <td>{{ $document->project_name }}</td>
                <td>{{ $document->land_name }}</td>
                <td>{{ $document->document_name }}</td>
                <td>{{ $document->document_taker }}</td>
                <td>{{ $document->witness_name }}</td>
                <td>{{ $document->vault_number }}</td>
                <td>{{ $document->vault_location }}</td>
                <td>{{ $document->proposed_return_date->format('d-m-Y') }}</td>
                <td>{{ ucfirst($document->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 