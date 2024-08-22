<!-- resources/views/notifications/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container" id="custom-container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 style="text-align:center; margin-bottom:25px;">Notifications</h1>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notification)
                        <tr>
                            <td>{{ $notification->data['message'] }}</td>
                            <td>{{ $notification->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">No notifications found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                @if ($notifications->onFirstPage())
                    <span>&laquo; Previous</span>
                @else
                    <a href="{{ $notifications->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                @endif

                @php
                    $start = max(1, $notifications->currentPage() - 5);
                    $end = min($notifications->lastPage(), $start + 9);
                @endphp

                @if ($start > 1)
                    <a href="{{ $notifications->url(1) }}">1</a>
                    @if ($start > 2)
                        <span class="dot">...</span>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $notifications->currentPage())
                        <span id="page-{{ $i }}" class="active">{{ $i }}</span>
                    @else
                        <a id="page-{{ $i }}" href="{{ $notifications->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if ($end < $notifications->lastPage())
                    @if ($end < $notifications->lastPage() - 1)
                        <span class="dot">...</span>
                    @endif
                    <a href="{{ $notifications->url($notifications->lastPage()) }}">{{ $notifications->lastPage() }}</a>
                @endif

                @if ($notifications->hasMorePages())
                    <a href="{{ $notifications->nextPageUrl() }}" rel="next">Next &raquo;</a>
                @else
                    <span>Next &raquo;</span>
                @endif
            </div>
        </div>
    </div>
@endsection

<link href="{{ asset('css/notifications.css') }}" rel="stylesheet">
