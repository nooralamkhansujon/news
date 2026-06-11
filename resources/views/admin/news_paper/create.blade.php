@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('News Paper Create') }}</div>

                <div class="card-body">
                    <form action="{{route('news-paper.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="date" name="publish_date" class="form-control"/>
                        </div>
    
                        <button class="btn btn-primary">Add</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
