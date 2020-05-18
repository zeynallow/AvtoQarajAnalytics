@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Settings</h1>
    </div>
    <div class="section-body">

      <a class="btn btn-success" href="{{route('settings.updatePermissions')}}">Update Permissions</a>

    </div>
  </section>
@endsection
