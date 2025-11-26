@extends('back.layout.page-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Site Setting</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            General Setting
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection