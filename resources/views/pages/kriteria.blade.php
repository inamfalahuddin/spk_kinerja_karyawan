@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Kriteria</h1>

            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                data-target="#exampleModalCenter">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                Tambah Kriteria
            </button>
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
                <table class="table table-bordered">
                    <tr>
                        <th>Keterangan</th>
                        @foreach ($data_aspek as $key => $item)
                        <td>{{$item}}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>Nilai</th>
                        @foreach ($data_aspek as $key => $item)
                        <td>{{$key}}</td>
                        @endforeach
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
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
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data_body) == 0)
                            <tr>
                                <td class="text-center" colspan="{{ count($data_header) }}">Data tidak ditemukan</td>
                            </tr>
                            @else
                            @foreach ($data_body as $key => $body)
                            <tr>
                                <td>{{$key +1}}</td>
                                <td class="text-capitalize">{{$body['id']}}</td>
                                <td class="text-capitalize">{{$body['nama']}}</td>
                                <td class="text-capitalize">{{$body['nilai']}}</td>
                                <td class="text-capitalize">{{$body['tipe']}}</td>
                                <td class="d-flex">
                                    <button class="btn btn-info btn-sm mr-1" data-toggle="modal"
                                        data-target="#editModal{{ $key }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#confirmDelete{{ $key }}">
                                        <i class="fas fa-trash-alt"></i>
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
                                                <span class="text-primary">{{$body['nama']}}</span>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('kriteria.update', $body['id']) }}" method="POST"
                                            class="user">
                                            @csrf
                                            @method('PUT')
                                            <!-- Gunakan PUT atau PATCH tergantung dari rute Laravel Anda -->

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="inputNama">Nama Kriteria</label>
                                                    <input type="text" class="form-control" id="inputNama" name="nama"
                                                        value="{{ $body['nama'] ?? old('nama') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputNilai">Nilai</label>
                                                    <input type="text" class="form-control" id="inputNilai" name="nilai"
                                                        value="{{ $body['nilai'] ?? old('nilai') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputTipe">Tipe</label>
                                                    <select class="form-control" id="inputTipe" name="tipe">
                                                        <option value="core" {{ ($body['tipe'] ?? old('tipe'))=='core'
                                                            ? 'selected' : '' }}>Core</option>
                                                        <option value="secondary" {{ ($body['tipe'] ??
                                                            old('tipe'))=='secondary' ? 'selected' : '' }}>Secondary
                                                        </option>
                                                    </select>
                                                </div>
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

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="confirmDelete{{ $key }}" tabindex="-1" role="dialog"
                                aria-labelledby="confirmDeleteLabel{{ $key }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteLabel{{ $key }}">Konfirmasi Hapus
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <!-- Form untuk Menghapus Data -->
                                            <form action="{{ route('kriteria.destroy', $body['id']) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </form>
                                        </div>
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

{{-- Modal --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('kriteria.store')}}" method="POST" class="user">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label for="inputNama">Nama Kriteria</label>
                        <input type="text" class="form-control" id="inputNama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="inputNilai">Nilai</label>
                        <input type="text" class="form-control" id="inputNilai" name="nilai">
                    </div>
                    <div class="form-group">
                        <label for="inputTipe">Tipe</label>
                        <select class="form-control" id="inputTipe" name="tipe">
                            <option value="core">Core</option>
                            <option value="secondary">Secondary</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
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