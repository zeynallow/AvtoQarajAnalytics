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
          <form class="" action="{{route('settings.roles.permissions.update',$role_id)}}" method="post">

            @foreach ($permissions as $key => $permission)
              <div class="row">
                <div class="col-md-2">
                  <input type="checkbox"
                  {{($permission->checkRole($role_id) > 0) ? 'checked' : '' }}
                  name="permission_id[]" value="{{$permission->id}}">
                </div>
                <div class="col-md-5">
                  {{$permission->controller}}
                </div>
                <div class="col-md-5">
                  {{$permission->method}}
                </div>
              </div>
            @endforeach
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-success">Yadda saxla</button>
              </div>
            </div>
            @csrf
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
