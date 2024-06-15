@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Penilaian</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

    </div>
</div>

{{-- Data Tables --}}
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                @foreach ($data_header as $head)
                                <th>{{$head}}</th>
                                @endforeach
                                @if (count($data_body) != 0)
                                @foreach ($data_body[0]['kriteria_data'] as $item)
                                <td class="text-capitalize">{{$item['nama_kriteria']}}</td>
                                @endforeach
                                @endif
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data_body) == 0)
                            <tr>
                                <td class="text-center" colspan="{{ count($data_header) + 1 }}">
                                    Data tidak ditemukan
                                </td>
                            </tr>
                            @else
                            @foreach ($data_body as $key => $body)
                            <tr>
                                <td>{{$key +1}}</td>
                                <td class="text-capitalize">{{$body['id']}}</td>
                                <td class="text-capitalize">{{$body['nama']}}</td>
                                @foreach ($body['kriteria_data'] as $item)
                                <td class="text-capitalize">{{$item['nilai']}}</td>
                                @endforeach
                                <td class="d-flex">
                                    <button class="btn btn-info btn-sm mr-1" data-toggle="modal"
                                        data-target="#editModal{{ $key }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Edit untuk setiap data -->
                            <div class="modal fade" id="editModal{{ $key }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{ $key }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $key }}">Edit Data
                                                <span class="text-primary">{{$body['id']}}</span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('nilai.update', $body['id']) }}" method="POST"
                                            class="user">
                                            @csrf
                                            @method('PUT')
                                            <!-- Gunakan PUT atau PATCH tergantung dari rute Laravel Anda -->

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="inputNama">Nama Karyawan</label>
                                                    <input type="text" class="form-control" id="inputNama" name="nama"
                                                        value="{{ $body['nama'] ?? old('nama') }}" disabled>
                                                </div>

                                                @foreach ($body['kriteria_data'] as $index => $item)
                                                <div class="form-group">
                                                    <label for="input{{$index}}">{{$item['nama_kriteria']}}</label>
                                                    <select class="form-control" id="input{{$index}}"
                                                        name="{{$item['id_kriteria']}}">
                                                        @foreach ($data_aspek as $value => $label)
                                                        <option value="{{$value}}" {{ (isset($item['nilai']) &&
                                                            $item['nilai']==$value) ? 'selected' : '' }}>
                                                            {{$label}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endforeach

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Kembali</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Data Tables --}}

@endsection

@push('styles')
<style>
    .password-container {
        position: relative;
    }

    .password-container input {
        padding-right: 40px;
        /* Space for the eye icon */
    }

    .password-container .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordInput = document.getElementById('inputPassword');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
@endpush