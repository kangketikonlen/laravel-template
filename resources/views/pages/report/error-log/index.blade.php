@php
    $html_tag_data = [];
    $title = 'Data Riwayat Error';
    $description = 'View Riwayat Error';
    $url = '/report/error-log';
    $breadcrumbs = ['/' => 'Home'];
@endphp
@extends('layout-private', ['html_tag_data' => $html_tag_data, 'title' => $title, 'description' => $description])

@section('css')
    <link rel="stylesheet" href="/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="/css/vendor/select2-bootstrap4.min.css" />
@endsection

@section('js_vendor')
    <script src="/js/cs/scrollspy.js"></script>
    <script src="/js/vendor/select2.full.min.js"></script>
@endsection

@section('js_page')
    <script src="/js/pages/report/error-log.js"></script>
@endsection

@section('content')
    <div class="container">
        <!-- Title and Top Buttons Start -->
        @include('_layout/breadcrumb')
        <!-- Title and Top Buttons End -->

        <!-- Item List Start -->
        <div class="card mb-5">
            <div id="item-list-search" class="card-header pt-2 pb-2" style="display: none">
                <div class="row g-3">
                    <div class="col">
                        <div class="w-100">
                            <select class="form-control" autocomplete="off" name="date-log">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                @if (session('alert'))
                    @php $status = session('alert')["status"] @endphp
                    @php $message = session('alert')["message"] @endphp
                    <x-alert :status="$status" :message="$message" />
                @endif
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col" class="text-nowrap">Timestamp</th>
                            <th scope="col" class="text-nowrap">Environment</th>
                            <th scope="col" class="text-nowrap">Type</th>
                            <th scope="col" class="text-nowrap">Message</th>
                        </tr>
                    </thead>
                    <tbody id="item-list"></tbody>
                </table>
            </div>
        </div>
        <!-- Item List End -->
    </div>
    <x-modal.activity-log :link="$url" />
@endsection
