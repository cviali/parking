<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nomor Polisi</th>
            <th>Kode Unik</th>
            <th>Pegawai</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Status</th>
            <th>Total Dibayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $car)
        <tr>
            <td>{{ $car->id }}</td>
            <td>{{ $car->nopol }}</td>
            <td>{{ $car->kode }}</td>
            <td>{{ $car->pegawai }}</td>
            <td>{{ $car->created_at }}</td>
            <td>
                @if($car->checkout === '1')
                    {{ $car->updated_at }}
                    @else
                    -
                @endif
            </td>
            <td>
                @if($car->checkout === '1')
                Checkout
                @else
                Not Yet
                @endif
            </td>
            <td>{{$car->cost}}</td>
        </tr>
        @endforeach
    </tbody>
</table>