@extends('layouts.app_admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Панель упраления @endslot
            @slot('parent') Главная @endslot
            @slot('active')  @endslot
        @endcomponent
    </section>
@endsection
