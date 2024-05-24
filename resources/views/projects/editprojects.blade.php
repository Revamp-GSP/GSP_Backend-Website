<!-- resources/views/projects/editproject.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container" id="projects-container">
        <h2>Edit Project</h2>
        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Field for nama_pekerjaan -->
            <div class="form-group">
                <label for="nama_pekerjaan">Nama Pekerjaan:</label>
                <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" class="form-control" value="{{ $project->nama_pekerjaan }}" required>
            </div>

            <!-- Dropdown for nama_service -->
            <div class="form-group">
                <label for="nama_service">Jenis Layanan:</label>
                <select name="nama_service" id="nama_service" class="form-control" required>
                    <option value="">Pilih Jenis Layanan</option>
                    @foreach($produks as $product)
                        <option value="{{ $product->nama_service }}" {{ $product->nama_service == $product->nama_service ? 'selected' : '' }}>{{ $product->nama_service }}</option>
                    @endforeach
                </select>
            </div>


            <!-- Field for nilai_pekerjaan_rkap -->
            <div class="form-group">
                <label for="nilai_pekerjaan_rkap">Nilai Pekerjaan RKAP:</label>
                <input type="number" name="nilai_pekerjaan_rkap" id="nilai_pekerjaan_rkap" class="form-control" value="{{ $project->nilai_pekerjaan_rkap }}" required>
            </div>

            <!-- Field for nilai_pekerjaan_aktual -->
            <div class="form-group">
                <label for="nilai_pekerjaan_aktual">Nilai Pekerjaan Aktual:</label>
                <input type="number" name="nilai_pekerjaan_aktual" id="nilai_pekerjaan_aktual" class="form-control" value="{{ $project->nilai_pekerjaan_aktual }}" required>
            </div>

            <!-- Field for nilai_pekerjaan_kontrak_tahun_berjalan -->
            <div class="form-group">
                <label for="nilai_pekerjaan_kontrak_tahun_berjalan">Nilai Pekerjaan Kontrak/Tahun/Berjalan:</label>
                <input type="number" name="nilai_pekerjaan_kontrak_tahun_berjalan" id="nilai_pekerjaan_kontrak_tahun_berjalan" class="form-control" value="{{ $project->nilai_pekerjaan_kontrak_tahun_berjalan }}" required>
            </div>

            <!-- Field for nama_pelanggan -->
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan:</label>
                <select name="nama_pelanggan" id="nama_pelanggan" class="form-control" required>
                    <option value="">Pilih Nama Pelanggan</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->nama_pelanggan }}" {{ $project->nama_pelanggan == $customer->nama_pelanggan ? 'selected' : '' }}>{{ $customer->nama_pelanggan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Field for plan_start_date -->
            <div class="form-group">
                <label for="plan_start_date">Plan Start Date:</label>
                <input type="date" name="plan_start_date" id="plan_start_date" class="form-control" value="{{ $project->plan_start_date }}">
            </div>

            <!-- Field for plan_end_date -->
            <div class="form-group">
                <label for="plan_end_date">Plan End Date:</label>
                <input type="date" name="plan_end_date" id="plan_end_date" class="form-control" value="{{ $project->plan_end_date }}">
            </div>

            <!-- Field for actual_start_date -->
            <div class="form-group">
                <label for="actual_start_date">Actual Start Date:</label>
                <input type="date" name="actual_start_date" id="actual_start_date" class="form-control" value="{{ $project->actual_start_date }}">
            </div>

            <!-- Field for actual_end_date -->
            <div class="form-group">
                <label for="actual_end_date">Actual End Date:</label>
                <input type="date" name="actual_end_date" id="actual_end_date" class="form-control" value="{{ $project->actual_end_date }}">
            </div>

            <!-- Dropdown for status -->
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="">Pilih Status</option>
                    <option value="Pending" {{ $project->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Follow Up" {{ $project->status == 'Follow Up' ? 'selected' : '' }}>Follow Up</option>
                    <option value="Implementasi" {{ $project->status == 'Implementasi' ? 'selected' : '' }}>Implementasi</option>
                    <option value="Pembayaran" {{ $project->status == 'Pembayaran' ? 'selected' : '' }}>Pembayaran</option>
                    <option value="Selesai" {{ $project->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Field for account_marketing -->
            <div class="form-group">
                <label for="account_marketing">Account Marketing:</label>
                <select name="account_marketing" id="account_marketing" class="form-control" required>
                    <option value="">None</option>
                    @foreach($grouped_account_marketing as $group)
                        <optgroup label="{{ $group['label'] }}">
                            @foreach($group['options'] as $option)
                                <option value="{{ $option }}" {{ $project->account_marketing == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="dirut">DIRUT:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_dirut_responsible" name="dirut" value="Responsible" {{ $project->dirut == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_dirut_responsible">Responsible</label>
                    <input type="radio" id="rasci_dirut_accountable" name="dirut" value="Accountable" {{ $project->dirut == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_dirut_accountable">Accountable</label>
                    <input type="radio" id="rasci_dirut_support" name="dirut" value="Support" {{ $project->dirut == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_dirut_support">Support</label>
                    <input type="radio" id="rasci_dirut_consulted" name="dirut" value="Consulted" {{ $project->dirut == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_dirut_consulted">Consulted</label>
                    <input type="radio" id="rasci_dirut_informed" name="dirut" value="Informed" {{ $project->dirut == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_dirut_informed">Informed</label>
                </div>
            </div>


            <!-- Radio buttons for DIROP -->
            <div class="form-group">
                <label for="dirop">DIROP:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_dirop_responsible" name="dirop" value="Responsible" {{ $project->dirop == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_dirop_responsible">Responsible</label>
                    <input type="radio" id="rasci_dirop_accountable" name="dirop" value="Accountable" {{ $project->dirop == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_dirop_accountable">Accountable</label>
                    <input type="radio" id="rasci_dirop_support" name="dirop" value="Support" {{ $project->dirop == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_dirop_support">Support</label>
                    <input type="radio" id="rasci_dirop_consulted" name="dirop" value="Consulted" {{ $project->dirop == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_dirop_consulted">Consulted</label>
                    <input type="radio" id="rasci_dirop_informed" name="dirop" value="Informed" {{ $project->dirop == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_dirop_informed">Informed</label>
                </div>
            </div>


            <!-- Radio buttons for DIRKE -->
            <div class="form-group">
                <label for="dirke">DIRKE:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_dirke_responsible" name="dirke" value="Responsible" {{ $project->dirke == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_dirke_responsible">Responsible</label>
                    <input type="radio" id="rasci_dirke_accountable" name="dirke" value="Accountable" {{ $project->dirke == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_dirke_accountable">Accountable</label>
                    <input type="radio" id="rasci_dirke_support" name="dirke" value="Support" {{ $project->dirke == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_dirke_support">Support</label>
                    <input type="radio" id="rasci_dirke_consulted" name="dirke" value="Consulted" {{ $project->dirke == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_dirke_consulted">Consulted</label>
                    <input type="radio" id="rasci_dirke_informed" name="dirke" value="Informed" {{ $project->dirke == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_dirke_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for KSKMR -->
            <div class="form-group">
                <label for="kskmr">KSKMR:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_kskmr_responsible" name="kskmr" value="Responsible" {{ $project->kskmr == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_kskmr_responsible">Responsible</label>
                    <input type="radio" id="rasci_kskmr_accountable" name="kskmr" value="Accountable" {{ $project->kskmr == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_kskmr_accountable">Accountable</label>
                    <input type="radio" id="rasci_kskmr_support" name="kskmr" value="Support" {{ $project->kskmr == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_kskmr_support">Support</label>
                    <input type="radio" id="rasci_kskmr_consulted" name="kskmr" value="Consulted" {{ $project->kskmr == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_kskmr_consulted">Consulted</label>
                    <input type="radio" id="rasci_kskmr_informed" name="kskmr" value="Informed" {{ $project->kskmr == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_kskmr_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for KSHAM -->
            <div class="form-group">
                <label for="ksham">KSHAM:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_ksham_responsible" name="ksham" value="Responsible" {{ $project->ksham == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_ksham_responsible">Responsible</label>
                    <input type="radio" id="rasci_ksham_accountable" name="ksham" value="Accountable" {{ $project->ksham == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_ksham_accountable">Accountable</label>
                    <input type="radio" id="rasci_ksham_support" name="ksham" value="Support" {{ $project->ksham == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_ksham_support">Support</label>
                    <input type="radio" id="rasci_ksham_consulted" name="ksham" value="Consulted" {{ $project->ksham == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_ksham_consulted">Consulted</label>
                    <input type="radio" id="rasci_ksham_informed" name="ksham" value="Informed" {{ $project->ksham == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_ksham_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MSDMU -->
            <div class="form-group">
                <label for="msdmu">MSDMU:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_msdmu_responsible" name="msdmu" value="Responsible" {{ $project->msdmu == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_msdmu_responsible">Responsible</label>
                    <input type="radio" id="rasci_msdmu_accountable" name="msdmu" value="Accountable" {{ $project->msdmu == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_msdmu_accountable">Accountable</label>
                    <input type="radio" id="rasci_msdmu_support" name="msdmu" value="Support" {{ $project->msdmu == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_msdmu_support">Support</label>
                    <input type="radio" id="rasci_msdmu_consulted" name="msdmu" value="Consulted" {{ $project->msdmu == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_msdmu_consulted">Consulted</label>
                    <input type="radio" id="rasci_msdmu_informed" name="msdmu" value="Informed" {{ $project->msdmu == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_msdmu_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MKAKT -->
            <div class="form-group">
                <label for="mkakt">MKAKT:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mkakt_responsible" name="mkakt" value="Responsible" {{ $project->mkakt == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_mkakt_responsible">Responsible</label>
                    <input type="radio" id="rasci_mkakt_accountable" name="mkakt" value="Accountable" {{ $project->mkakt == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_mkakt_accountable">Accountable</label>
                    <input type="radio" id="rasci_mkakt_support" name="mkakt" value="Support" {{ $project->mkakt == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_mkakt_support">Support</label>
                    <input type="radio" id="rasci_mkakt_consulted" name="mkakt" value="Consulted" {{ $project->mkakt == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_mkakt_consulted">Consulted</label>
                    <input type="radio" id="rasci_mkakt_informed" name="mkakt" value="Informed" {{ $project->mkakt == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_mkakt_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MBILP -->
            <div class="form-group">
                <label for="mbilp">MBILP:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mbilp_responsible" name="mbilp" value="Responsible" {{ $project->mbilp == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_mbilp_responsible">Responsible</label>
                    <input type="radio" id="rasci_mbilp_accountable" name="mbilp" value="Accountable" {{ $project->mbilp == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_mbilp_accountable">Accountable</label>
                    <input type="radio" id="rasci_mbilp_support" name="mbilp" value="Support" {{ $project->mbilp == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_mbilp_support">Support</label>
                    <input type="radio" id="rasci_mbilp_consulted" name="mbilp" value="Consulted" {{ $project->mbilp == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_mbilp_consulted">Consulted</label>
                    <input type="radio" id="rasci_mbilp_informed" name="mbilp" value="Informed" {{ $project->mbilp == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_mbilp_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MPPTI -->
            <div class="form-group">
                <label for="mppti">MPPTI:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mppti_responsible" name="mppti" value="Responsible" {{ $project->mppti == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_mppti_responsible">Responsible</label>
                    <input type="radio" id="rasci_mppti_accountable" name="mppti" value="Accountable" {{ $project->mppti == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_mppti_accountable">Accountable</label>
                    <input type="radio" id="rasci_mppti_support" name="mppti" value="Support" {{ $project->mppti == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_mppti_support">Support</label>
                    <input type="radio" id="rasci_mppti_consulted" name="mppti" value="Consulted" {{ $project->mppti == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_mppti_consulted">Consulted</label>
                    <input type="radio" id="rasci_mppti_informed" name="mppti" value="Informed" {{ $project->mppti == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_mppti_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MOPTI -->
            <div class="form-group">
                <label for="mopti">MOPTI:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mopti_responsible" name="mopti" value="Responsible" {{ $project->mopti == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_mopti_responsible">Responsible</label>
                    <input type="radio" id="rasci_mopti_accountable" name="mopti" value="Accountable" {{ $project->mopti == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_mopti_accountable">Accountable</label>
                    <input type="radio" id="rasci_mopti_support" name="mopti" value="Support" {{ $project->mopti == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_mopti_support">Support</label>
                    <input type="radio" id="rasci_mopti_consulted" name="mopti" value="Consulted" {{ $project->mopti == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_mopti_consulted">Consulted</label>
                    <input type="radio" id="rasci_mopti_informed" name="mopti" value="Informed" {{ $project->mopti == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_mopti_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MBSAR -->
            <div class="form-group">
                <label for="mbsar">MBSAR:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_mbsar_responsible" name="mbsar" value="Responsible" {{ $project->mbsar == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_mbsar_responsible">Responsible</label>
                    <input type="radio" id="rasci_mbsar_accountable" name="mbsar" value="Accountable" {{ $project->mbsar == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_mbsar_accountable">Accountable</label>
                    <input type="radio" id="rasci_mbsar_support" name="mbsar" value="Support" {{ $project->mbsar == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_mbsar_support">Support</label>
                    <input type="radio" id="rasci_mbsar_consulted" name="mbsar" value="Consulted" {{ $project->mbsar == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_mbsar_consulted">Consulted</label>
                    <input type="radio" id="rasci_mbsar_informed" name="mbsar" value="Informed" {{ $project->mbsar == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_mbsar_informed">Informed</label>
                </div>
            </div>

            <!-- Radio buttons for MSADB -->
            <div class="form-group">
                <label for="msadb">MSADB:</label>
                <div class="radio-buttons">
                    <input type="radio" id="rasci_msadb_responsible" name="msadb" value="Responsible" {{ $project->msadb == 'Responsible' ? 'checked' : '' }}>
                    <label for="rasci_msadb_responsible">Responsible</label>
                    <input type="radio" id="rasci_msadb_accountable" name="msadb" value="Accountable" {{ $project->msadb == 'Accountable' ? 'checked' : '' }}>
                    <label for="rasci_msadb_accountable">Accountable</label>
                    <input type="radio" id="rasci_msadb_support" name="msadb" value="Support" {{ $project->msadb == 'Support' ? 'checked' : '' }}>
                    <label for="rasci_msadb_support">Support</label>
                    <input type="radio" id="rasci_msadb_consulted" name="msadb" value="Consulted" {{ $project->msadb == 'Consulted' ? 'checked' : '' }}>
                    <label for="rasci_msadb_consulted">Consulted</label>
                    <input type="radio" id="rasci_msadb_informed" name="msadb" value="Informed" {{ $project->msadb == 'Informed' ? 'checked' : '' }}>
                    <label for="rasci_msadb_informed">Informed</label>
                </div>
            </div>


            <!-- Button to submit form -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
@endsection

<link href="{{ asset('css/projects.css') }}" rel="stylesheet">

