<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
            width: 30%;
        }
    </style>
</head>
<body>
    <h1>Approval Sheet</h1>
    <h3>Proposal: {{ $proposal->title }}</h3>

    <p><strong>Description:</strong> {{ $proposal->description }}</p>
    <p><strong>Type:</strong> {{ ucfirst($proposal->type) }}</p>
    <p><strong>Submitted By:</strong> {{ $proposal->user->username }}</p>
    <p><strong>Date Submitted:</strong> {{ $proposal->date_submitted }}</p>

    <h3>Approval Status</h3>
    <table>
        <thead>
            <tr>
                <th>Role</th>
                <th>Status</th>
                <th>Approved By</th>
                <th>Approval Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($approvedRoles as $role)
                <tr>
                    <td>{{ $role }}</td>
                    <td>Approved</td>
                    <td>{{ Auth::where('role->name', $role)->first()->username ?? 'N/A' }}</td>
                    <td>{{ now()->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <div>
            <p>Submitted By:</p>
            <p>_____________________</p>
        </div>
        <div>
            <p>Reviewed By:</p>
            <p>_____________________</p>
        </div>
        <div>
            <p>Approved By:</p>
            <p>_____________________</p>
        </div>
    </div>
</body>
</html>
