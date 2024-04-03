<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card" style="border: 2px solid #3490dc; border-radius: 10px;;width:30%;height:60%;padding:50px">
                <div class="card-body">
                    <h5 class="card-title" style="color: #3490dc; font-weight: bold;">Manage Users</h5>
                    <p class="card-text"></p>
                   @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                        <div class="mt-3">
                            <a href="{{ route('dashboards.index') }}" class="btn btn-primary" style="background-color: #3490dc; border-color: #3490dc;padding:10px;border-radius:10px">Go to Users</a>
                        </div>
                    @else
                        <div class="mt-3">

                        <a href="{{ route('leaves.index') }}" class="btn btn-primary" style="background-color: #3490dc; border-color: #3490dc;padding:10px;border-radius:10px">Go to Users</a>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
