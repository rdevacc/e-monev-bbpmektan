<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style type="text/css">
        table{
            width: 100%;
        }
        table.autowidth td{
        white-space:nowrap;
        }
        table, th, td {
           border: 1px solid black; 
           border-collapse: collapse;    
        }
        thead, th {
            background-color: #e6e6e7;
            text-align: center;
        }
        td {
            text-align: left;
            vertical-align: top;
        }
        td > p {
            margin-top: 0px;
        }
    </style>

<table>
    <thead>
        <tr class="table-danger">
            <th>No</th>
            <th>Judul Kegiatan</th>
            <th>Kelompok</th>
            <th>Subkelompok</th>
            <th>Penanggung Jawab</th>
            <th>Anggaran PJ</th>
            <th>Target Keuangan</th>
            <th>Realisasi Keuangan</th>
            <th>Target Fisik</th>
            <th>Realisasi Fisik</th>
            <th>Kegiatan yang sudah dikerjakan</th>
            <th>Permasalahan</th>
            <th>Tindak Lanjut</th>
            <th>Kegiatan yang akan dilakukan ({{ $next_month }})
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activities as $activity )
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $activity->name }}</td>
                <td>{{ $activity->field->name }}</td>
                <td>{{ $activity->group->name }}</td>
                <td>{{ $activity->user->name }}</td>
                <td>Rp.{{ $activity->field->budget }}</td>
                <td>{{ $activity->financial_target  }}</td>
                <td>{{ $activity->financial_realization  }}</td>
                <td>{{ $activity->physical_target  }}</td>
                <td>{{ $activity->physical_realization  }}</td>
                <td>
                    @foreach($activity->dones as $done )
                        @if($done["value"])
                            <p>{{ $loop->iteration }}. {{ $done["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
                <td>
                    @foreach($activity->problems as $problem )
                        @if($problem["value"])
                            <p>{{ $loop->iteration }}. {{ $problem["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
                <td>
                    @foreach($activity->follow_up as $follow )
                        @if($follow["value"])
                            <p>{{ $loop->iteration }}. {{ $follow["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
                <td>
                    @foreach($activity->todos as $todo )
                        @if($todo["value"])
                            <p>{{ $loop->iteration }}. {{ $todo["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>