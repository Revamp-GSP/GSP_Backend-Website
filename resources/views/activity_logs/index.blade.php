<!-- resources/views/activity_logs/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container" id="custom-container">
        <h1 style="text-align:center; margin-bottom:25px;">Activity Logs</h1>
        <form action="{{ route('activity-log.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#deleteAllModal">Delete All</button>
        </form>

        <div class="table-responsive"> <!-- Tambahkan kelas table-responsive -->
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Subject</th>
                        <th>URL</th>
                        <th>Method</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>User</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->subject }}</td>
                            <td>{{ $log->url }}</td>
                            <td>{{ $log->method }}</td>
                            <td>{{ $log->ip }}</td>
                            <td>{{ $log->agent }}</td>
                            <td>{{ $log->user ? $log->user->name : 'Guest' }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            @if ($logs->onFirstPage())
                <span>&laquo; Previous</span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
            @endif

            @if ($logs->lastPage() > 1)
                @for ($i = 1; $i <= $logs->lastPage(); $i++)
                    @if ($i == $logs->currentPage())
                        <span id="page-{{ $i }}" class="active">{{ $i }}</span>
                    @else
                        <a id="page-{{ $i }}" href="{{ $logs->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor
            @endif

            @if ($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" rel="next">Next &raquo;</a>
            @else
                <span>Next &raquo;</span>
            @endif
        </div>

    <!-- Modal untuk konfirmasi menghapus semua aktivitas -->
    <div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAllModalLabel">Delete All Activity Logs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete all activity logs?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('activity-log.delete-all') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete All</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<link href="{{ asset('css/activity.css') }}" rel="stylesheet">
