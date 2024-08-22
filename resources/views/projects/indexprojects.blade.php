@extends('layouts.app')

@section('content')
<div class="container" id="custom-container">
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
    @endif
        <div class="row">
            <div class="col-md-12" id="filter">
                <!-- Filter by date range -->
                <form action="{{ route('projects.index') }}" method="GET" style="margin-bottom: 5px;">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="start-date-input">Start Date:</label>
                            <input type="date" name="date_range_start" id="start-date-input" class="form-control form-control-sm" placeholder="Start Date" value="{{ request('date_range_start') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="end-date-input">End Date:</label>
                            <input type="date" name="date_range_end" id="end-date-input" class="form-control form-control-sm" placeholder="End Date" value="{{ request('date_range_end') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" id="filter-button" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="search-create-wrapper">
            <a href="{{ route('projects.create') }}" class="btn btn-primary" id="btnsw">Add New Project</a>

            <form action="{{ route('projects.index') }}" method="GET" style="margin-bottom:15px; margin-right:25px;">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                <button type="submit" id="btnsw">Search</button>
            </form>
        </div>
        <div class="row justify-content-end">
            <div class="table-responsive">
                <table id="projects-table" class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Aksi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Nama Pekerjaan</th>
                            <th scope="col">Nama Layanan</th>
                            <th scope="col">Nilai Pekerjaan RKAP</th>
                            <th scope="col">Nilai Pekerjaan Aktual</th>
                            <th scope="col">Nilai Pekerjaan Kontrak Tahun Berjalan</th>
                            <th scope="col">Plan Start Date</th>
                            <th scope="col">Plan End Date</th>
                            <th scope="col">Actual Start Date</th>
                            <th scope="col">Actual End Date</th>
                            <th scope="col">Account Marketing</th>
                            <th scope="col">Dirut</th>
                            <th scope="col">Dirop</th>
                            <th scope="col">Dirke</th>
                            <th scope="col">KSKMR</th>
                            <th scope="col">KSHAM</th>
                            <th scope="col">MSDMU</th>
                            <th scope="col">MKAKT</th>
                            <th scope="col">MBILP</th>
                            <th scope="col">MPPTI</th>
                            <th scope="col">MOPTI</th>
                            <th scope="col">MBSAR</th>
                            <th scope="col">MSADB</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $baseNumber = ($projects->currentPage() - 1) * $projects->perPage() + 1;
                            $totalNilaiRkap = 0;
                            $totalNilaiAktual = 0;
                            $totalNilaiKontrak = 0;
                        @endphp
                        @foreach($projects as $project)
                        @php
                            $totalNilaiRkap += $project->nilai_pekerjaan_rkap;
                            $totalNilaiAktual += $project->nilai_pekerjaan_aktual;
                            $totalNilaiKontrak += $project->nilai_pekerjaan_kontrak_tahun_berjalan;
                        @endphp
                        <tr>
                            <td>{{ $baseNumber + $loop->index }}</td>                          
                            <td>
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                            <td>
                                <span class="status-btn" style="background-color: {{ getStatusColor($project->status) }}">{{ $project->status }}</span>
                            </td>
                            <td><a href="{{ route('projects.show', $project->nama_pekerjaan) }}">{{ $project->nama_pekerjaan }}</a></td>
                            <td>{{ $project->nama_service }}</td>
                            <td>{{ number_format($project->nilai_pekerjaan_rkap, 0, ',', '.') }}</td>
                            <td>{{ number_format($project->nilai_pekerjaan_aktual, 0, ',', '.') }}</td>
                            <td>{{ number_format($project->nilai_pekerjaan_kontrak_tahun_berjalan, 0, ',', '.') }}</td>
                            <td>{{ $project->plan_start_date }}</td>
                            <td>{{ $project->plan_end_date }}</td>
                            <td>{{ $project->actual_start_date }}</td>
                            <td>{{ $project->actual_end_date }}</td>
                            <td>{{ $project->account_marketing }}</td>
                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->dirut) }}">{{ $project->dirut }}</span>
                            </td>
                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->dirop) }}">{{ $project->dirop }}</span>
                            </td>
                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->dirke) }}">{{ $project->dirke }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->kskmr) }}">{{ $project->kskmr }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->ksham) }}">{{ $project->ksham }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->msdmu) }}">{{ $project->msdmu }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->mkakt) }}">{{ $project->mkakt }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->mbilp) }}">{{ $project->mbilp }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->mppti) }}">{{ $project->mppti }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->mopti) }}">{{ $project->mopti }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->mbsar) }}">{{ $project->mbsar }}</span>
                            </td>

                            <td>
                                <span class="status-btn" style="background-color: {{ getRasciColor($project->msadb) }}">{{ $project->msadb }}</span>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Baris total -->
                        <tr>
                            <td colspan="5"></td>
                            <td>{{ number_format($totalNilaiRkap, 0, ',', '.') }}</td>
                            <td>{{ number_format($totalNilaiAktual, 0, ',', '.') }}</td>
                            <td>{{ number_format($totalNilaiKontrak, 0, ',', '.') }}</td>
                            <td colspan="18"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination">
            @if ($projects->onFirstPage())
                <span>&laquo; Previous</span>
            @else
                <a href="{{ $projects->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
            @endif

            @php
                $start = max(1, $projects->currentPage() - 5);
                $end = min($projects->lastPage(), $start + 9);
            @endphp

            @if ($start > 1)
                <a href="{{ $projects->url(1) }}">1</a>
                @if ($start > 2)
                    <span class="dot">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $projects->currentPage())
                    <span id="page-{{ $i }}" class="active">{{ $i }}</span>
                @else
                    <a id="page-{{ $i }}" href="{{ $projects->url($i) }}">{{ $i }}</a>
                @endif
            @endfor

            @if ($end < $projects->lastPage())
                @if ($end < $projects->lastPage() - 1)
                    <span class="dot">...</span>
                @endif
                <a href="{{ $projects->url($projects->lastPage()) }}">{{ $projects->lastPage() }}</a>
            @endif

            @if ($projects->hasMorePages())
                <a href="{{ $projects->nextPageUrl() }}" rel="next">Next &raquo;</a>
            @else
                <span>Next &raquo;</span>
            @endif
        </div>


@endsection

@php
function getRasciColor($rasci) {
    switch ($rasci) {
        case 'Responsible':
            return 'green';
        case 'Accountable':
            return 'blue';
        case 'Support':
            return 'orange';
        case 'Consulted':
            return 'purple';
        case 'Informed':
            return 'red';
        default:
            return 'black';
    }
}
function getStatusColor($status) {
    switch ($status) {
        case 'Finished':
            return 'green';
        case 'Payment':
            return 'blue';
        case 'Implementasi':
            return 'orange';
        case 'Follow Up':
            return 'purple';
        case 'Postpone':
            return 'red';
        default:
            return 'black';
    }
}
@endphp

<link href="{{ asset('css/projects.css') }}" rel="stylesheet">
