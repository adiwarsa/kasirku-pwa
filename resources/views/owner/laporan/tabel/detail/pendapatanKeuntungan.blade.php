<style>
    .detail-pendapatan-keuntungan th {
        background-color: darkgray !important;
    }

    .data2 td {
        border-top: 5px solid black;
        text-align: right;
    }

    .border td {
        border-top: 2px solid black;
        text-align: center;
        color: red !important;
    }

    .border2 td {
        border-top: 2px solid black;

    }

    .detail-pendapatan-keuntungan {
        color: white;
    }
</style>
<div class="table-responsive" style="background-color: darkgray;">
    <table class="table table-bordered detail-pendapatan-keuntungan">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                @if ($status == 'pendapatan')
                    <th>Status</th>
                    <th>Total Pembayaran</th>
                @elseif($status == 'keuntungan')
                    <th>Total Keuntungan</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $num => $value)
                <?php
                $nerf = 0;
                if ($num > 0) {
                    $nerf = $num - 1;
                }
                $counter = 1;
                for ($x = 1; $x < count($data); $x++) {
                    if ($value['invoice'] == $data[$x]['invoice']) {
                        $counter++;
                    }
                }
                ?>
                <tr>
                    <td <?php
                    if ($num > 0) {
                        if ($data[$nerf]['invoice'] != $value['invoice']) {
                            $counter -= 1;
                        }
                    }
                    if ($counter > 0) {
                        echo "rowspan='" . $counter . "'";
                        if ($counter > 1) {
                            echo "style='vertical-align: middle;'";
                        }
                    
                        if ($num > 0) {
                            if ($data[$nerf]['invoice'] == $value['invoice']) {
                                echo 'hidden';
                            }
                        }
                    }
                    ?>>
                        {{ $num + 1 }}
                    </td>
                    <td class="text-left" <?php
                    if ($counter > 0) {
                        echo "rowspan='" . $counter . "'";
                        if ($counter > 1) {
                            echo "style='vertical-align: middle;'";
                        }
                    
                        if ($num > 0) {
                            if ($data[$nerf]['invoice'] == $value['invoice']) {
                                echo 'hidden';
                            }
                        }
                    }
                    ?>>
                        {{ $value['invoice'] }}
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($value['tanggal'])->isoFormat('DD-MM-YYYY') }}
                    </td>
                    @if ($status == 'pendapatan')
                        <td>{{ $value['status'] }}</td>
                    @endif
                    <td class="text-right">@currency2($value['total'])</td>
                </tr>
            @endforeach
        </tbody>
        <tr class="data2">
            <td colspan="
            @if ($status == 'pendapatan') 4 @else 3 @endif" class="text-right">Sub Total
            </td>
            <td class="text-right">@currency2($sub_total)</td>
        </tr>
    </table>
</div>
