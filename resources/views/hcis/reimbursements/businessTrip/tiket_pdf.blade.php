<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Voucher Form</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            width: 100%;
            height: auto;
        }

        .header img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
        }

        h5 {
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        p {
            margin-top: 4px;
            margin-bottom: 2px;
            padding: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        td {
            padding: 2px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .label {
            width: 30%;
        }

        .colon {
            width: 20px;
            text-align: center;
        }

        .value {
            width: 70%;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('images/kop.jpg') }}" alt="Kop Surat">
    </div>
    <h5 class="center">TICKET FORM</h5>
    <h5 class="center">No. {{ $ticket->no_sppd }}</h5>

    <table>
        <p>Harap dipesankan tiket sebagai berikut :</p>
        <p><b>Detail tiket yang dipesan :</b></p>
    </table>

    <table>
        <tr>
            <td colspan="3"><b>Passenger Information:</b></td>
        </tr>
        @foreach ($passengers as $index => $passenger)
            <tr>
                <td colspan="3"><b>Passenger {{ $index + 1 }}:</b></td>
            </tr>
            <tr>
                <td class="label">Passenger Name</td>
                <td class="colon">:</td>
                <td class="value">{{ $passenger->np_tkt }}</td>
            </tr>
            <tr>
                <td class="label">Phone Number</td>
                <td class="colon">:</td>
                <td class="value">{{ $passenger->tlp_tkt }}</td>
            </tr>
            <tr>
                <td class="label">Gender</td>
                <td class="colon">:</td>
                <td class="value">{{ $passenger->jk_tkt }}</td>
            </tr>
            <tr>
                <td class="label">Destination</td>
                <td class="colon">:</td>
                <td class="value">{{ $passenger->dari_tkt }} - {{ $passenger->ke_tkt }}</td>
            </tr>
            <tr>
                <td class="label">Departure Date</td>
                <td class="colon">:</td>
                <td class="value">
                    @php
                        $formattedDate = Carbon\Carbon::parse($passenger->tgl_brkt_tkt)->format('d F Y');
                        $formattedTime = Carbon\Carbon::parse($passenger->jam_brkt_tkt)->format('H:i');
                    @endphp
                    {{ $formattedDate }}, {{ $formattedTime }} WIB
                </td>
            </tr>
            @if ($passenger->type_tkt != 'One Way')
                <tr>
                    <td class="label">Return Date</td>
                    <td class="colon">:</td>
                    <td class="value">
                        @php
                            $formattedReturnDate = Carbon\Carbon::parse($passenger->tgl_plg_tkt)->format('d F Y');
                            $formattedReturnTime = Carbon\Carbon::parse($passenger->jam_plg_tkt)->format('H:i');
                        @endphp
                        {{ $formattedReturnDate }}, {{ $formattedReturnTime }} WIB
                    </td>
                </tr>
            @endif
            <tr>
                <td class="label">Ticket Type</td>
                <td class="colon">:</td>
                <td class="value">{{ $passenger->jenis_tkt }}</td>
            </tr>
            <tr>
                <td class="label">Travel Type</td>
                <td class="colon">:</td>
                <td class="value"><b>{{ $passenger->type_tkt }}</b></td>
            </tr>
            <tr>
                <td class="label">Under the Burden of PT</td>
                <td class="colon">:</td>
                <td class="value">{{ $passenger->company_name }}</td>
            </tr>
            <tr>
                <td class="label">Cost Center</td>
                <td class="colon">:</td>
                <td class="value"><b>{{ $passenger->cost_center ?? '0' }}</b></td>
            </tr>
            @if (!$loop->last)
                <tr>
                    <td colspan="3">
                        <br>
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

    <table>
        <tr>
            <td colspan="3"><b>Disetujui Oleh :</b></td>
        </tr>
        <tr>
            <td class="label">Nama Atasan 1</td>
            <td class="colon">:</td>
            <td class="value">{{ $ticket->businessTrip->atasan_1 }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ $ticket->businessTrip->tanggal_atasan_1 }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="label">Nama Atasan 2</td>
            <td class="colon">:</td>
            <td class="value">{{ $ticket->businessTrip->atasan_2 }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ $ticket->businessTrip->tanggal_atasan_2 }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="label">HRD</td>
            <td class="colon">:</td>
            <td class="value">{{ $ticket->businessTrip->hrd }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ $ticket->businessTrip->tanggal_hrd }}</td>
        </tr>
    </table>
</body>

</html>
