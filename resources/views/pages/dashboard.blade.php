@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col text-gray-700">
        <div class="card p-3">
            <h2 class="h3 text-gray-800 mb-3">Selamat Datang, {{Auth::user()->username}}</h2>
            <h3 class="h4 mb-0 text-gray-800">
                SPK Penilaian Kinerja Karyawan dengan Menggunakan Metode Profile Matching
            </h3>
            <hr>

            <p>
                Algoritma Profile Matching adalah metode yang digunakan untuk mencari kesamaan antara dua buah profil
                yang berbeda. Metode ini digunakan untuk mencari kesamaan antara profil karyawan dengan profil pekerjaan
                yang diinginkan. Metode ini akan menghasilkan nilai kesesuaian antara profil karyawan dengan profil
                pekerjaan yang diinginkan. Nilai tersebut akan digunakan untuk menentukan karyawan yang paling sesuai
                dengan pekerjaan yang diinginkan.
            </p>

            <p>
                keuntungan menggunakan metode ini adalah dapat menentukan karyawan yang paling sesuai dengan pekerjaan
                yang diinginkan. Dengan menggunakan metode ini, perusahaan dapat menentukan karyawan yang paling sesuai
                dengan pekerjaan yang diinginkan. Dengan demikian, perusahaan dapat memilih karyawan yang paling sesuai
                dan dapat meningkatkan produktivitas perusahaan.

            <p>
                Tahapan dalam metode Profile Matching adalah sebagai berikut:
            </p>
            <ol>
                <li>Menentukan profil karyawan</li>
                <li>Menentukan profil pekerjaan yang diinginkan</li>
                <li>Menghitung nilai kesesuaian antara profil karyawan dengan profil pekerjaan yang diinginkan</li>
                <li>Menentukan karyawan yang paling sesuai dengan pekerjaan yang diinginkan</li>
            </ol>

            <p>Kelebihan :
            <ul>
                <li>Metode ini dapat menentukan karyawan yang paling sesuai dengan pekerjaan yang diinginkan</li>
                <li>Metode ini dapat meningkatkan produktivitas perusahaan</li>
                <li>Metode ini dapat digunakan untuk menentukan karyawan yang paling sesuai dengan pekerjaan yang
                    diinginkan</li>
            </ul>
            </p>

            <p>
                Kekurangan :
            <ul>
                <li>Metode ini memerlukan data yang lengkap dan akurat</li>
                <li>Metode ini memerlukan waktu yang cukup lama untuk menghitung nilai kesesuaian antara profil karyawan
                    dengan profil pekerjaan yang diinginkan</li>
                <li>Metode ini memerlukan biaya yang cukup besar untuk menghitung nilai kesesuaian antara profil
                    karyawan dengan profil pekerjaan yang diinginkan</li>
            </ul>
            </p>
        </div>
    </div>
</div>

@endsection