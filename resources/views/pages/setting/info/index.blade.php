@php
    $html_tag_data = [];
    $title = 'Formulir Informasi Applikasi';
    $description = 'Edit Informasi Applikasi';
    $url = '/setting/info';
    $breadcrumbs = ['/' => 'Home', $url => 'View Informasi Applikasi'];
@endphp
@extends('layout-private', ['html_tag_data' => $html_tag_data, 'title' => $title, 'description' => $description])

@section('css')
@endsection

@section('js_vendor')
@endsection

@section('js_page')
@endsection

@section('content')
    <div class="container">
        <!-- Title Start -->
        @include('_layout/breadcrumb')
        <!-- Title End -->

        <!-- Form Start -->
        <form method="POST" action="{{ $url }}/update" class="card mb-5 tooltip-end-top">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if (session('alert'))
                    @php $status = session('alert')["status"] @endphp
                    @php $message = session('alert')["message"] @endphp
                    <x-alert :status="$status" :message="$message" />
                @endif
                <div class="row g-3 mb-3">
                    <div class="col">
                        <div class="w-100">
                            <label class="form-label" for="name">
                                Nama
                                @error('name')
                                    <span class="text-danger"><br />{{ $message }}</span>
                                @enderror
                            </label>
                            <input class="form-control" autocomplete="off" id="name" name="name"
                                value="{{ $appInfo->name }}">
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col">
                        <div class="w-100">
                            <label class="form-label" for="description">
                                Deskripsi Aplikasi
                                @error('description')
                                    <span class="text-danger"><br />{{ $message }}</span>
                                @enderror
                            </label>
                            <textarea class="form-control" autocomplete="off" id="description" name="description">{{ $appInfo->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col">
                        <div class="w-100">
                            <label class="form-label" for="dev">
                                Developer
                                @error('dev')
                                    <span class="text-danger"><br />{{ $message }}</span>
                                @enderror
                            </label>
                            <input class="form-control" autocomplete="off" id="dev" name="dev"
                                value="{{ $appInfo->dev }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="w-100">
                            <label class="form-label" for="dev_url">
                                Developer Url
                                @error('dev_url')
                                    <span class="text-danger"><br />{{ $message }}</span>
                                @enderror
                            </label>
                            <input class="form-control" autocomplete="off" id="dev_url" name="dev_url"
                                value="{{ $appInfo->dev_url }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="w-100">
                            <label class="form-label" for="registered">
                                Registered
                                @error('registered')
                                    <span class="text-danger"><br />{{ $message }}</span>
                                @enderror
                            </label>
                            <input class="form-control" autocomplete="off" id="registered" name="registered"
                                value="{{ $appInfo->registered }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end pt-3 pb-3">
                <x-buttons.submit />
            </div>
        </form>
        <!-- Form End -->
    </div>
@endsection
