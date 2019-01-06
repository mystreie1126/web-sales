@extends('template')

@section('content')

<form  action="{{route('sendToPos')}}" method="post">
  <input type="text" value="3047" name="id_customer">
  <input type="text" value="PGNQJLOWA" name="reference">

  <button type="button">send</button>
  {{csrf_field()}}
</form>

@stop
