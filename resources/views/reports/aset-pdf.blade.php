
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Aset</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
        }

        .header h2 {
            margin: 0 0 5px;
            font-size: 17px;
        }

        .header p {
            margin: 0;
            font-size: 10px;
        }

        .info {
            margin-bottom: 12px;
            line-height: 1.7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #777;
            padding: 7px 5px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #e9ecef;
            font-weight: bold;
            text-align: center;
        }

        td.no {
            text-align: center;
            width: 30px;
        }

        tr {
            page-break-inside: avoid;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 9px;
        }

        .empty {
            text-align: center;
            padding: 15px;
        }
    </style>
</head>

<body>

    {{-- Header perusahaan --}}
    <div class="header">
        <h2>PT GOLDEN PIPING INDONESIA</h2>
        <p>LAPORAN DATA INVENTARIS ASET</p>
    </div>

    {{-- Informasi laporan --}}
    <div class="info">
        <strong>Periode:</strong>

        {{ $dari ? \Carbon\Carbon::parse($dari)->format('d-m-Y') : 'Semua tanggal' }}

        s/d

        {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d-m-Y') : 'Semua tanggal' }}

        <br>

        <strong>Total Data:</strong>
        {{ number_format($total, 0, ',', '.') }} Aset
    </div>

    {{-- Pengaturan kolom --}}
    @php
        $labels = [
            'kode_aset' => 'Kode Aset',
            'nama_aset' => 'Nama Aset',
            'tanggal_pembelian' => 'Tanggal Perolehan',
            'kategori' => 'Kategori',
            'lokasi' => 'Lokasi',
            'divisi' => 'Divisi',
            'kondisi' => 'Kondisi',
            'status' => 'Status',
            'penanggung_jawab' => 'Penanggung Jawab',
        ];

        $selectedColumns = array_values(array_filter(
            $columns,
            fn($column) => isset($labels[$column])
        ));
    @endphp

    {{-- Tabel aset --}}
    <table>

        <thead>
            <tr>
                <th>No</th>

                @foreach($selectedColumns as $column)
                    <th>{{ $labels[$column] }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>

            @forelse($rows as $index => $row)

                <tr>

                    <td class="no">
                        {{ $index + 1 }}
                    </td>

                    @foreach($selectedColumns as $column)

                        <td>

                            @php
                                $value = $row->{$column} ?? null;
                            @endphp

                            @if($column === 'tanggal_pembelian' && $value)

                                {{ \Carbon\Carbon::parse($value)->format('d-m-Y') }}

                            @elseif($value === null || $value === '')

                                -

                            @else

                                {{ $value }}

                            @endif

                        </td>

                    @endforeach

                </tr>

            @empty

                <tr>
                    <td
                        colspan="{{ count($selectedColumns) + 1 }}"
                        class="empty"
                    >
                        Belum ada data aset.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    {{-- Footer --}}
    <div class="footer">
        Dicetak pada:
        {{ now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>
