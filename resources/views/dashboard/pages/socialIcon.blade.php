@extends('dashboard.layouts.app')

@section('admin_content')

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5 mb-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>social Icon</h3>
                </div>
                <div class="card-body">

                    <button type="button" class="btn btn-secondary mb-3 add_item_admin">Add item</button>

                    <form method="POST" action="{{ route('socialIcon.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="link">link</label>
                            <div class="input-group">
                                <input type="url" name="link" id="link" class="form-control" value="{{ old('link') }}" placeholder="link">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="icon">icon</label>

                            <a href="https://icons.getbootstrap.com/" target="_blank">bootstrap</a>
                            <div class="input-group">
                                <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon') }}" placeholder="icon">
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>links</th>
                    <th>icons</th>
                    <th>Actions</th>
                    <th>DELETE</th>
                </tr>
            </thead>
            <tbody>
                @if($socialIcon->count() > 0)
                @foreach($socialIcon as $social)
                <tr>
                    <form action="{{ route('socialIcon.update', $social->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>
                            <input type="text" name="link" class="form-control" value="{{ $social->link }}">
                        </td>
                        <td>
                            <center>{!! $social->icon !!}</center>
                            <input type="text" name="icon" class="form-control" value="{{ $social->icon }}">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success">Update</button>
                        </td>
                    </form>

                    <td>
                        <form action="{{ route('socialIcon.destroy', $social->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this social Icon?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td>No data</td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>
</div>

@endsection