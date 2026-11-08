<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $report['title'] }}</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 25px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0 0 5px;
            font-size: 18px;
        }

        .header h3 {
            margin: 0;
            font-size: 13px;
            font-weight: normal;
        }

        .info {
            margin-bottom: 12px;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #555;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: #e9ecef;
            text-align: center;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .empty {
            text-align: center;
            padding: 15px;
        }

        .footer {
            margin-top: 15px;
            font-size: 9px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>PT GOLDEN PIPING INDONESIA</h2>
        <h3>{{ $report['title'] }}</h3>
    </div>

    <div class="info">
        <strong>Tanggal Cetak:</strong>
        {{ date('d-m-Y H:i') }}
        <br>

        <strong>Periode:</strong>
        {{ $dari ? date('d-m-Y', strtotime($dari)) : 'Semua tanggal' }}
        sampai
        {{ $sampai ? date('d-m-Y', strtotime($sampai)) : 'Sekarang' }}
        <br>

        <strong>Total Data:</strong>
        {{ $total }} data
    </div>

    <table>
        <thead>
            <tr>
                @foreach ($columns as $column)
                    @if (!in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at', 'foto']))
                        <th>
                            {{ ucwords(str_replace('_', ' ', $column)) }}
                        </th>
                    @endif
                @endforeach
            </tr>
        </thead>

        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($columns as $column)
                        @if (!in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at', 'foto']))
                            <td>
                                {{ $row->$column ?? '-' }}
                            </td>
                        @endif
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ max(1, count($columns)) }}" class="empty">
                        Tidak ada data laporan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen dibuat oleh Sistem Informasi E-Asset
        <br>
        PT Golden Piping Indonesia
    </div>

</body>
</html>
