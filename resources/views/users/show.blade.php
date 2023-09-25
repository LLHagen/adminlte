@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $user->first_name . ' ' . $user->last_name }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body p-0">

                            <div class="px-4 py-3 alert-info rounded-top">
                                {{ 'Собития пользователя' }}
                            </div>
                            @if($user->events->isEmpty())
                                <div class="p-4">
                                    {{ 'Нет Собитий' }}
                                </div>
                            @else
                                <table class="table">
                                    <tbody>
                                    @foreach($user->events as $eventItem)
                                        <tr>
                                            <td>
                                                <a href="{{ route('events.show', $eventItem) }}">{{ $eventItem->title }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <!-- /.card-body -->

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
