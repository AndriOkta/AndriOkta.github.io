<button class="btn btn-primary btn-sm tombol-edit" data-id="{{ $data->id }}" data-kk-id="{{ $data->kk_id }}" style="padding: 0.25rem 0.5rem" onclick="setModalTitle('Edit Data Anggota', {{ $data->id }})">
    <i class="material-icons" style="font-size:1.0rem">edit</i>
</button>

<button class="btn btn-danger btn-sm tombol-delete" data-id="{{ $data->id }}" data-kk-id="{{ $data->kk_id }}" style="padding: 0.25rem 0.5rem;">
    <i class="material-icons" style="font-size:1.0rem">delete</i>
</button>
