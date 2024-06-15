@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Penilaian Kinerja Karyawan</h1>
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

{{-- pemetaan GAP --}}
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Pemetaan GAP</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataGAP" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-capitalize">ID</th>
                                <th class="text-capitalize">Nama Karyawan</th>
                                @if (count($data_body) == 0)
                                <th class="text-center" colspan="{{ count($data_header) }}">Data tidak ditemukan</th>
                                @else
                                @foreach ($data_body[0]['nilai'] as $item)
                                <th class="text-capitalize">{{$item['id_kriteria']}}</th>
                                @endforeach
                                @endif
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
                                <td class="text-capitalize">{{$body['id_karyawan']}}</td>
                                <td class="text-capitalize" style="text-transform: capitalize !important;">
                                    {{$body['nama_karyawan']}}
                                </td>
                                @foreach ($body['nilai'] as $item)
                                <td class="text-capitalize text-center">{{$item['selisih']}}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- pemetaan Bobot --}}
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Pemetaan Bobot Berdasarkan GAP</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataGAP" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-capitalize">ID</th>
                                <th class="text-capitalize">Nama Karyawan</th>
                                @if (count($data_body) == 0)
                                <th class="text-center" colspan="{{ count($data_header) }}">Data tidak ditemukan</th>
                                @else
                                @foreach ($data_body[0]['nilai'] as $item)
                                <th class="text-capitalize">{{$item['id_kriteria']}}</th>
                                @endforeach
                                @endif
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
                                <td class="text-capitalize">{{$body['id_karyawan']}}</td>
                                <td class="text-capitalize" style="text-transform: capitalize !important;">
                                    {{$body['nama_karyawan']}}
                                </td>
                                @foreach ($body['nilai'] as $item)
                                <td class="text-capitalize text-center">{{$item['bobot_nilai']}}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- pemetaan ranking --}}
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Hasil Perangkingan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataGAP" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                @foreach ($data_header as $item)
                                <th class="text-capitalize text-center">{{$item}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data_result) == 0)
                            <tr>
                                <td class="text-center" colspan="{{ count($data_header) }}">Data tidak ditemukan</td>
                            </tr>
                            @else
                            @foreach ($data_result as $key => $body)
                            <tr>
                                <td class="text-capitalize text-info cursor-pointer" data-toggle="modal"
                                    data-target="#editModal{{ $key }}" style="cursor: pointer">
                                    {{$body['id_karyawan']}}
                                </td>
                                <td class="text-capitalize" style="text-transform: capitalize !important;">
                                    {{$body['nama']}}
                                </td>
                                <td class="text-center">{{ number_format($body['cf'], 3) }}</td>
                                <td class="text-center">{{ number_format($body['sf'], 3) }}</td>
                                <td class="text-center">{{ number_format($body['cf_x_percent'], 3) }}</td>
                                <td class="text-center">{{ number_format($body['sf_x_percent'], 3) }}</td>
                                <td class="text-center">{{ number_format($body['total_percent'], 3) }}</td>
                                <td class="text-center">{{$key+1}}</td>
                            </tr>

                            <!-- Modal Edit untuk setiap data -->
                            <div class="modal fade" id="editModal{{ $key }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{ $key }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="editModalLabel{{ $key }}">Detail
                                                Perhitungan
                                                <span class="text-primary">{{$body['nama']}}</span>
                                            </h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-2">N</div>
                                                        <div class="col">= (75% * NCF) + (25% * NSCF)</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2">N</div>
                                                        <div class="col">= (75% * {{$body['cf']}}) + (25% *
                                                            {{$body['cf']}})
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2">N</div>
                                                        <div class="col">= {{$body['cf_x_percent']}} +
                                                            {{$body['sf_x_percent']}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2">N</div>
                                                        <div class="col">= {{$body['total_percent']}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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