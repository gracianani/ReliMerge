@extends('layouts.app')

@section('content')

<script>
    Echo.channel('block.3')
    .listen('DashboardBlockUpdated', (e) => {
        console.log('xxx');
    });
  </script>
@endsection
