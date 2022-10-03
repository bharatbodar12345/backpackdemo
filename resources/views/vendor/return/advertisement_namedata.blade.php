<div>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Advertisement Name</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($entry as $data )
                <tr>
                <td>{{ $data->name }}</td>
                @if($data->status == 1)
                <td>{{$data->status = "Active"}}</td>
                @else
                <td>{{$data->status ='Deactive'}}</td>
                @endif
            @endforeach

        </tbody>

    </table>
</div>
