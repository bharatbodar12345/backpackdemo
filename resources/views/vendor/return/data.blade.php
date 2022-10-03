<div>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Category_type</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($entry->attribute as $data )
                <tr>
                <td>{{ $data->type_name }}</td>
                @if($data->status == 1)
                <td>{{$data->status = "Active";}}</td>
                @else
                <td>{{$data->status ='Deactive'}}</td>
                @endif
                </tr>
            @endforeach

        </tbody>

    </table>
</div>
