@extends('index')
@section('title', 'Create Task Group')
@section('css')
<style>
    .input-data{
    height: 50px;
    position: relative;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    .input-data input{
    padding-left: 10px;
    font-size: 22px;
    font-weight: 600;
    height: 50px;
    width: 100%;
    border: none;
    }

    .input-data input:focus{
        outline: none;
    }

    .input-data .underline{
    position: absolute;
    height: 2px;
    width: 100%;
    bottom: 0;
    }

    .input-data .underline:before{
    position: absolute;
    content: "";
    height: 100%;
    width: 100%;
    background: #4158d0;
    transform: scaleX(0);
    transform-origin: center;
    transition: transform 0.3s ease;
    }

    input:focus ~ .underline:before{
        transform: scaleX(1);
    }

    .wrapper .save{
        background: hsl(73, 99%, 73%); 
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        margin-left: 20px;
        width: 70px;
        height: 40px;
        text-align: center;
        border: #e5e5e5;
    }

    .wrapper .save:hover{
        font-weight: 600;
        background: hsl(73, 99%, 73%); 
    }
</style>
@endsection
@section('content')

<div class="taskgroup-wrap d-flex" style="height: 85vh">
    <form action="{{ route('task_groups.store') }}" method="post">
        @csrf
        <div class="wrapper d-flex mx-3">
            <div class="input-data">
                    <input type="text" name="name" id="" class="input-title">
                    <div class="underline"></div>
            </div>
            <button type="submit" class="btn save" style="align-self: flex-end">Save</button>
        </div>
    </form>
</div>
@endsection