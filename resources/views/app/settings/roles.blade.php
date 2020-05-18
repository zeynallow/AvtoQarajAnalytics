@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Settings</h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-md-12">
              @if($roles)
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Adı</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($roles as $key => $role)
                      <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->role_name}}</td>
                        <td><a class="btn btn-sm btn-info" href="{{route('settings.roles.permissions',$role->id)}}">İcazələr</a></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
