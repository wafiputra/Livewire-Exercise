@extends('layouts.app')

@section('content')
    <livewire:student>
@endsection

@section('script')
<script>
    window.addEventListener('close-modal', event => {
        $('#studentModal').modal('hide');
        $('#updateStudentModal').modal('hide');
    })
</script>
@endsection
