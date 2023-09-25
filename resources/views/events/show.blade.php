@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 ml-3">{{ $event->title }}</h1>
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

                    <div class="card rounded-3 mb-4">
                        <div class="card-body p-4">
                            <p>
                                {{ $event->text }}
                            </p>

                            <p class="mb-n1" style="font-size: 0.8rem;color: gray">
                                {{ 'Дата создания: ' . $event->created_at }}
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="px-4 py-3 alert-info rounded-top">
                                {{ 'Участники' }}
                            </div>
                            @if($users->isEmpty())
                                    <div class="p-4">
                                        {{ 'Нет участников' }}
                                    </div>
                            @else
                            <table class="table">
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ route('users.show', $user) }}">{{ $user->first_name . ' ' . $user->last_name }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div>
                    </div>

                    @if ($event->participants()->get()->pluck('id')->search(\Illuminate\Support\Facades\Auth::user()?->id) !== false )
                        <div class="card-footer clearfix">
                            <button onclick="detach()">
                                {{"Отказаться от участия"}}
                            </button>
                        </div>
                    @else
                        <div class="card-footer clearfix">
                            <button onclick="attach()">
                                {{"Принять участие"}}
                            </button>
                        </div>
                    @endif

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <script>
        function attach()
        {
            axios.post('{{ route('events.participants.attach', ['event' => $event]) }}')
                .then(function (response) {
                    location. reload()
                })
                .catch(function (error) {
                    console.error(error);
                });
        }

        function detach()
        {
            axios.post('{{ route('events.participants.detach', ['event' => $event]) }}')
                .then(function (response) {
                    location. reload()
                })
                .catch(function (error) {
                    console.error(error);
                });
        }
    </script>

@endsection
