@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Karyawan</h1>

            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                data-target="#exampleModalCenter">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                Tambah Karyawan
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
                                <td class="text-capitalize">{{$body['jenis_kelamin']}}</td>
                                <td class="text-capitalize">{{$body['tempat_lahir']}}</td>
                                <td>
                                    {{ \Illuminate\Support\Carbon::parse($body['tanggal_lahir'])->format('d/m/Y') }}
                                </td>
                                <td style="overflow-x: auto;">{{$body['alamat']}}</td>
                                <td class="d-flex">
                                    <button class="btn btn-info btn-sm mx-1" data-toggle="modal"
                                        data-target="#editModal{{ $key }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal"
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
                                        <form action="{{ route('karyawan.update', $body['id']) }}" method="POST"
                                            class="user">
                                            @csrf
                                            @method('PUT')
                                            <!-- Gunakan PUT atau PATCH tergantung dari rute Laravel Anda -->

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="inputNama">Nama Karyawan</label>
                                                    <input type="text" class="form-control" id="inputNama" name="nama"
                                                        value="{{ $body['nama'] ?? old('nama') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputJenisKelamin">Jenis Kelamin</label>
                                                    <select class="form-control" id="inputJenisKelamin"
                                                        name="jenis_kelamin">
                                                        <option value="L" {{ ($body['jenis_kelamin'] ??
                                                            old('jenis_kelamin'))=='L' ? 'selected' : '' }}>Laki-laki
                                                        </option>
                                                        <option value="P" {{ ($body['jenis_kelamin'] ??
                                                            old('jenis_kelamin'))=='P' ? 'selected' : '' }}>Perempuan
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputUsername">Alamat Karyawan</label>
                                                    <input type="text" class="form-control" id="inputUsername"
                                                        name="alamat" value="{{ $body['alamat'] ?? old('alamat') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tempatLahir">Tempat Lahir</label>
                                                    <input type="text" class="form-control" id="tempatLahir"
                                                        name="tempat_lahir"
                                                        value="{{ $body['tempat_lahir'] ?? old('tempat_lahir') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggalLahir">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" id="tanggalLahir"
                                                        name="tanggal_lahir"
                                                        value="{{ $body['tanggal_lahir'] ?? old('tanggal_lahir') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="noTelepon">No Telepon</label>
                                                    <input type="number" class="form-control" id="noTelepon"
                                                        name="telepon" value="{{ $body['telepon'] ?? old('telepon') }}">
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
                                            <form action="{{ route('karyawan.destroy', $body['id']) }}" method="POST"
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
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('karyawan.store')}}" method="POST" class="user">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label for="inputNama">Nama Karyawan</label>
                        <input type="text" class="form-control" id="inputNama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="inputJenisKelamin">Jenis Kelamin</label>
                        <select class="form-control" id="inputJenisKelamin" name="jenis_kelamin">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputUsername">Alamat Karyawan</label>
                        <input type="text" class="form-control" id="inputUsername" name="alamat">
                    </div>
                    <div class="form-group">
                        <label for="tempatLahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempatLahir" name="tempat_lahir">
                    </div>
                    <div class="form-group">
                        <label for="tanggalLahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggalLahir" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label for="noTelepon">No Telepon</label>
                        <input type="number" class="form-control" id="noTelepon" name="telepon">
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