@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('News Paper') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="pb-3">
                        <a href="{{route('news-paper.create')}}" class="btn btn-primary">Add New</a>
                    </div>
                    

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news_papers as $news_paper)
                            <tr>
                                <td>{{$news_paper->id}}</td>
                                <td>{{$news_paper->publish_date}}</td>
                                <td></td>
                                <td>
                                    <a class="btn btn-primary" href="{{route('news-paper.edit', $news_paper->id)}}">Edit<a/>
                                        <form action="{{route('news-paper.delete', $news_paper->id)}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('News Pages and all frame will be deleted. Confirm ?');">DELETE</button>
                                        </form>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        
                    </table>
                    {{$news_papers->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
