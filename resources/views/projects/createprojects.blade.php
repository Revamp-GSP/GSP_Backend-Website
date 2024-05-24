
@extends('layouts.app')

@section('content')
    <div class="container" id="projects-container">
        <h2>Create New Project</h2>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <!-- Field for nama_pekerjaan -->
            <div class="form-group">
                <label for="nama_pekerjaan">Nama Pekerjaan:</label>
                <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" class="form-control" required>
            </div>

            <!-- Dropdown for nama_service -->
            <div class="form-group">
                <label for="nama_service">Jenis Layanan:</label>
                <select name="nama_service" id="nama_service" class="form-control" required>
                    <option value="">Pilih Jenis Layanan</option>
                    @foreach($produks as $product)
                        <option value="{{ $product->nama_service }}">{{ $product->nama_service }}</option>
                    @endforeach
                </select>
            </div>


            <!-- Field for nilai_pekerjaan_rkap -->
            <div class="form-group">
                <label for="nilai_pekerjaan_rkap">Nilai Pekerjaan RKAP:</label>
                <input type="number" name="nilai_pekerjaan_rkap" id="nilai_pekerjaan_rkap" class="form-control" required>
            </div>

            <!-- Field for nilai_pekerjaan_aktual -->
            <div class="form-group">
                <label for="nilai_pekerjaan_aktual">Nilai Pekerjaan Aktual:</label>
                <input type="number" name="nilai_pekerjaan_aktual" id="nilai_pekerjaan_aktual" class="form-control" required>
            </div>

            <!-- Field for nilai_pekerjaan_kontrak_tahun_berjalan -->
            <div class="form-group">
                <label for="nilai_pekerjaan_kontrak_tahun_berjalan">Nilai Pekerjaan Kontrak/Tahun/Berjalan:</label>
                <input type="number" name="nilai_pekerjaan_kontrak_tahun_berjalan" id="nilai_pekerjaan_kontrak_tahun_berjalan" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan:</label>
                <select name="nama_pelanggan" id="nama_pelanggan" class="form-control" required>
                    <option value="">Pilih Nama Pelanggan</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->nama_pelanggan }}">{{ $customer->nama_pelanggan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Field for plan_start_date -->
            <div class="form-group">
                <label for="plan_start_date">Plan Start Date:</label>
                <input type="date" name="plan_start_date" id="plan_start_date" class="form-control">
            </div>

            <!-- Field for plan_end_date -->
            <div class="form-group">
                <label for="plan_end_date">Plan End Date:</label>
                <input type="date" name="plan_end_date" id="plan_end_date" class="form-control">
            </div>

            <!-- Field for actual_start_date -->
            <div class="form-group">
                <label for="actual_start_date">Actual Start Date:</label>
                <input type="date" name="actual_start_date" id="actual_start_date" class="form-control">
            </div>

            <!-- Field for actual_end_date -->
            <div class="form-group">
                <label for="actual_end_date">Actual End Date:</label>
                <input type="date" name="actual_end_date" id="actual_end_date" class="form-control">
            </div>

            <!-- Dropdown for status -->
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Pending">Postpone</option>
                    <option value="Follow Up">Follow Up</option>
                    <option value="Implementasi">Implementasi</option>
                    <option value="Pembayaran">Pembayaran</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_marketing">Account Marketing:</label>
                <select name="account_marketing" id="account_marketing" class="form-control" required>
                    <option value="">None</option>
                    <optgroup label="Administrator">
                        <option value="Ahmad Gunawan">Ahmad Gunawan</option>
                        <option value="Sugih Permana">Sugih Permana</option>
                        <option value="Yana Nugraha">Yana Nugraha</option>
                    </optgroup>
                    <optgroup label="Busdev">
                        <option value="Admin Sales">Admin Sales</option>
                        <option value="Alia Almitra">Alia Almitra</option>
                        <option value="Aufa Putra">Aufa Putra</option>
                        <option value="Desiana Latief">Desiana Latief</option>
                        <option value="Greyta Sarah">Greyta Sarah</option>
                        <option value="Hadi Mustofa">Hadi Mustofa</option>
                        <option value="Harry Fitriana">Harry Fitriana</option>
                        <option value="Isma Soraya">Isma Soraya</option>
                        <option value="Johanes B. Indra">Johanes B. Indra</option>
                        <option value="Mulyana Santosa">Mulyana Santosa</option>
                        <option value="Olley Mosye">Olley Mosye</option>
                        <option value="Ramdani Apriansyah">Ramdani Apriansyah</option>
                        <option value="Ryan Apriantho">Ryan Apriantho</option>
                        <option value="Sarah Thoharhatunissa">Sarah Thoharhatunissa</option>
                        <option value="Topan Permata">Topan Permata</option>
                        <option value="Winda Sundayani">Winda Sundayani</option>
                    </optgroup>
                    <optgroup label="Direksi">
                        <option value="Bayu Mahendra">Bayu Mahendra</option>
                        <option value="Burhanuddin -">Burhanuddin -</option>
                        <option value="Ruly Fasri">Ruly Fasri</option>
                    </optgroup>
                    <optgroup label="Manager Keuangan">
                        <option value="Elsa Marina">Elsa Marina</option>
                        <option value="Oki Satrya">Oki Satrya </option>
                        <option value="Taufik Munandar">Taufik Munandar</option>
                    </optgroup>
                    <optgroup label="Manager Ophar">
                        <option value="Dadang Sutriaman">Dadang Sutriaman</option>
                    </optgroup>  
                    <optgroup label="Ophar">
                        <option value="Asep Nugroho">Asep Nugroho</option>
                        <option value="Dadang Sutriaman">Dadang Sutriaman</option>
                        <option value="Fauzy Dalil Mutaqin">Fauzy Dalil Mutaqin</option>
                        <option value="M. Hafila Hardenera">M. Hafila Hardenera</option>
                        <option value="Umi Kencanawati">Umi Kencanawati</option>
                    </optgroup>
                    <optgroup label="Sat Kinerja">
                        <option value="32">Hernowo Hardono</option>
                    </optgroup>      
                    <optgroup label="SDM">
                        <option value="Agus Salam">Agus Salam</option>
                        <option value="Teddy R. Asmara">Teddy R. Asmara</option>
                    </optgroup>                
                </select>
            </div>

            <!-- Radio buttons for DIRUT -->
            <div class="form-group">
                <label for="dirut">DIRUT:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_dirut_responsible" name="dirut" value="Responsible">
                    <label for="rasci_dirut_responsible">Responsible</label>
                    <input type="radio" id="rasci_dirut_accountable" name="dirut" value="Accountable">
                    <label for="rasci_dirut_accountable">Accountable</label>
                    <input type="radio" id="rasci_dirut_support" name="dirut" value="Support">
                    <label for="rasci_dirut_support">Support</label>
                    <input type="radio" id="rasci_dirut_consulted" name="dirut" value="Consulted">
                    <label for="rasci_dirut_consulted">Consulted</label>
                    <input type="radio" id="rasci_dirut_informed" name="dirut" value="Informed">
                    <label for="rasci_dirut_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for DIROP -->
            <div class="form-group">
                <label for="dirop">DIROP:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_dirop_responsible" name="dirop" value="Responsible">
                    <label for="rasci_dirop_responsible">Responsible</label>
                    <input type="radio" id="rasci_dirop_accountable" name="dirop" value="Accountable">
                    <label for="rasci_dirop_accountable">Accountable</label>
                    <input type="radio" id="rasci_dirop_support" name="dirop" value="Support">
                    <label for="rasci_dirop_support">Support</label>
                    <input type="radio" id="rasci_dirop_consulted" name="dirop" value="Consulted">
                    <label for="rasci_dirop_consulted">Consulted</label>
                    <input type="radio" id="rasci_dirop_informed" name="dirop" value="Informed">
                    <label for="rasci_dirop_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for DIRKE -->
            <div class="form-group">
                <label for="dirke">DIRKE:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_dirke_responsible" name="dirke" value="Responsible">
                    <label for="rasci_dirke_responsible">Responsible</label>
                    <input type="radio" id="rasci_dirke_accountable" name="dirke" value="Accountable">
                    <label for="rasci_dirke_accountable">Accountable</label>
                    <input type="radio" id="rasci_dirke_support" name="dirke" value="Support">
                    <label for="rasci_dirke_support">Support</label>
                    <input type="radio" id="rasci_dirke_consulted" name="dirke" value="Consulted">
                    <label for="rasci_dirke_consulted">Consulted</label>
                    <input type="radio" id="rasci_dirke_informed" name="dirke" value="Informed">
                    <label for="rasci_dirke_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for KSKMR -->
            <div class="form-group">
                <label for="kskmr">KSKMR:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_kskmr_responsible" name="kskmr" value="Responsible">
                    <label for="rasci_kskmr_responsible">Responsible</label>
                    <input type="radio" id="rasci_kskmr_accountable" name="kskmr" value="Accountable">
                    <label for="rasci_kskmr_accountable">Accountable</label>
                    <input type="radio" id="rasci_kskmr_support" name="kskmr" value="Support">
                    <label for="rasci_kskmr_support">Support</label>
                    <input type="radio" id="rasci_kskmr_consulted" name="kskmr" value="Consulted">
                    <label for="rasci_kskmr_consulted">Consulted</label>
                    <input type="radio" id="rasci_kskmr_informed" name="kskmr" value="Informed">
                    <label for="rasci_kskmr_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for KSHAM -->
            <div class="form-group">
                <label for="ksham">KSHAM:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_ksham_responsible" name="ksham" value="Responsible">
                    <label for="rasci_ksham_responsible">Responsible</label>
                    <input type="radio" id="rasci_ksham_accountable" name="ksham" value="Accountable">
                    <label for="rasci_ksham_accountable">Accountable</label>
                    <input type="radio" id="rasci_ksham_support" name="ksham" value="Support">
                    <label for="rasci_ksham_support">Support</label>
                    <input type="radio" id="rasci_ksham_consulted" name="ksham" value="Consulted">
                    <label for="rasci_ksham_consulted">Consulted</label>
                    <input type="radio" id="rasci_ksham_informed" name="ksham" value="Informed">
                    <label for="rasci_ksham_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MSDMU -->
            <div class="form-group">
                <label for="msdmu">MSDMU:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_msdmu_responsible" name="msdmu" value="Responsible">
                    <label for="rasci_msdmu_responsible">Responsible</label>
                    <input type="radio" id="rasci_msdmu_accountable" name="msdmu" value="Accountable">
                    <label for="rasci_msdmu_accountable">Accountable</label>
                    <input type="radio" id="rasci_msdmu_support" name="msdmu" value="Support">
                    <label for="rasci_msdmu_support">Support</label>
                    <input type="radio" id="rasci_msdmu_consulted" name="msdmu" value="Consulted">
                    <label for="rasci_msdmu_consulted">Consulted</label>
                    <input type="radio" id="rasci_msdmu_informed" name="msdmu" value="Informed">
                    <label for="rasci_msdmu_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MKAKT -->
            <div class="form-group">
                <label for="mkakt">MKAKT:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mkakt_responsible" name="mkakt" value="Responsible">
                    <label for="rasci_mkakt_responsible">Responsible</label>
                    <input type="radio" id="rasci_mkakt_accountable" name="mkakt" value="Accountable">
                    <label for="rasci_mkakt_accountable">Accountable</label>
                    <input type="radio" id="rasci_mkakt_support" name="mkakt" value="Support">
                    <label for="rasci_mkakt_support">Support</label>
                    <input type="radio" id="rasci_mkakt_consulted" name="mkakt" value="Consulted">
                    <label for="rasci_mkakt_consulted">Consulted</label>
                    <input type="radio" id="rasci_mkakt_informed" name="mkakt" value="Informed">
                    <label for="rasci_mkakt_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MBILP -->
            <div class="form-group">
                <label for="mbilp">MBILP:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mbilp_responsible" name="mbilp" value="Responsible">
                    <label for="rasci_mbilp_responsible">Responsible</label>
                    <input type="radio" id="rasci_mbilp_accountable" name="mbilp" value="Accountable">
                    <label for="rasci_mbilp_accountable">Accountable</label>
                    <input type="radio" id="rasci_mbilp_support" name="mbilp" value="Support">
                    <label for="rasci_mbilp_support">Support</label>
                    <input type="radio" id="rasci_mbilp_consulted" name="mbilp" value="Consulted">
                    <label for="rasci_mbilp_consulted">Consulted</label>
                    <input type="radio" id="rasci_mbilp_informed" name="mbilp" value="Informed">
                    <label for="rasci_mbilp_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MPPTI -->
            <div class="form-group">
                <label for="mppti">MPPTI:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mppti_responsible" name="mppti" value="Responsible">
                    <label for="rasci_mppti_responsible">Responsible</label>
                    <input type="radio" id="rasci_mppti_accountable" name="mppti" value="Accountable">
                    <label for="rasci_mppti_accountable">Accountable</label>
                    <input type="radio" id="rasci_mppti_support" name="mppti" value="Support">
                    <label for="rasci_mppti_support">Support</label>
                    <input type="radio" id="rasci_mppti_consulted" name="mppti" value="Consulted">
                    <label for="rasci_mppti_consulted">Consulted</label>
                    <input type="radio" id="rasci_mppti_informed" name="mppti" value="Informed">
                    <label for="rasci_mppti_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MOPTI -->
            <div class="form-group">
                <label for="mopti">MOPTI:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mopti_responsible" name="mopti" value="Responsible">
                    <label for="rasci_mopti_responsible">Responsible</label>
                    <input type="radio" id="rasci_mopti_accountable" name="mopti" value="Accountable">
                    <label for="rasci_mopti_accountable">Accountable</label>
                    <input type="radio" id="rasci_mopti_support" name="mopti" value="Support">
                    <label for="rasci_mopti_support">Support</label>
                    <input type="radio" id="rasci_mopti_consulted" name="mopti" value="Consulted">
                    <label for="rasci_mopti_consulted">Consulted</label>
                    <input type="radio" id="rasci_mopti_informed" name="mopti" value="Informed">
                    <label for="rasci_mopti_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MBSAR -->
            <div class="form-group">
                <label for="mbsar">MBSAR:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mbsar_responsible" name="mbsar" value="Responsible">
                    <label for="rasci_mbsar_responsible">Responsible</label>
                    <input type="radio" id="rasci_mbsar_accountable" name="mbsar" value="Accountable">
                    <label for="rasci_mbsar_accountable">Accountable</label>
                    <input type="radio" id="rasci_mbsar_support" name="mbsar" value="Support">
                    <label for="rasci_mbsar_support">Support</label>
                    <input type="radio" id="rasci_mbsar_consulted" name="mbsar" value="Consulted">
                    <label for="rasci_mbsar_consulted">Consulted</label>
                    <input type="radio" id="rasci_mbsar_informed" name="mbsar" value="Informed">
                    <label for="rasci_mbsar_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MSADB -->
            <div class="form-group">
                <label for="msadb">MSADB:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_msadb_responsible" name="msadb" value="Responsible">
                    <label for="rasci_msadb_responsible">Responsible</label>
                    <input type="radio" id="rasci_msadb_accountable" name="msadb" value="Accountable">
                    <label for="rasci_msadb_accountable">Accountable</label>
                    <input type="radio" id="rasci_msadb_support" name="msadb" value="Support">
                    <label for="rasci_msadb_support">Support</label>
                    <input type="radio" id="rasci_msadb_consulted" name="msadb" value="Consulted">
                    <label for="rasci_msadb_consulted">Consulted</label>
                    <input type="radio" id="rasci_msadb_informed" name="msadb" value="Informed">
                    <label for="rasci_msadb_informed">Informed</label>
                </div>
            </div>

            <!-- Button to submit form -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
@endsection


<link href="{{ asset('css/projects.css') }}" rel="stylesheet">
