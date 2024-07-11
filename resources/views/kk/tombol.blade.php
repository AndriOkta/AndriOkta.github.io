<button class="btn btn-info btn-sm tombol-detail" data-id="{{ $data->id }}" style="padding: 0.25rem 0.5rem">
    <i class="fas fa-info-circle" style="font-size:0.8rem"></i>
</button>

<button class="btn btn-primary btn-sm tombol-edit" data-id="{{ $data->id }}" style="padding: 0.25rem 0.5rem" data-toggle="modal" data-target="#exampleModal" onclick="setModalTitle('Edit Data Keluarga', {{ $data->id }})">
    <i class="material-icons" style="font-size:1.0rem">edit</i>
</button>  
<button class="btn btn-danger btn-sm tombol-delete" data-id="{{ $data->id }}" style="padding: 0.25rem 0.5rem;"><i class="material-icons" style="font-size:1.0rem">delete</i></button>
