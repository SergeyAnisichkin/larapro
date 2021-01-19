@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                <a class="btn btn-primary" href="{{ route('blog.admin.posts.create') }}">
                    Написать
                </a>
            </nav>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Автор</td>
                            <td>Категория</td>
                            <td>Заголовок</td>
                            <td>Дата публикации</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginator as $item)
                            @php /** @var App\Models\BlogPost $item */ @endphp
                            <tr @if(!$item->is_published) style="background-color: #ccc;" @endif>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->category->title }}</td>
                                <td>
                                    <a href="{{ route('blog.admin.posts.edit', $item->id) }}">{{ $item->title }}</a>
                                </td>
                                <td>{{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d.M H:i') : '' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($paginator->total() > $paginator->count())
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{ $paginator->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
