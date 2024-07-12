<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
</head>
<body>
<table border="1" cellpading="0" cellspacing="0">
            <tr align="left">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Salary</th>
            </tr>

            @if($payslips->isNotEmpty())
            @foreach($payslips as $slip)

            <tr align="left">
                <td>{{$slip->id}}</td>
                <td>{{$slip->name}}</td>
                <td>{{$slip->email}}</td>
                <td>{{$slip->salary}}</td>
            </tr>
            @endforeach
            @endif
        </table>
    
</body>
</html>