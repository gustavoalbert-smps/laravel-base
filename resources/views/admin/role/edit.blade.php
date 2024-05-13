<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section>
                        <header class="mb-4">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Roles') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Configure system role permissions.') }}
                            </p>
                        </header>
                        
                        <div id="tree">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


@section('scripts')
<script>
    $('#tree').bstreeview({
        expandIcon: 'bi bi-caret-down-square',
        collapseIcon: 'bi bi-caret-right-square'
    });
</script>
@endsection