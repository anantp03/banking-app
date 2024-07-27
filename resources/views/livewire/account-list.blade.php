<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>

    <section>
        <div class="container">
            <div class="py-12">
                <table id="accounts-list" class="display table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>Date Of Birth</th>
                        <th>Balance</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ ucfirst($account->firstname) ." ". ucfirst($account->lastname) }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>{{ $account->dob }}</td>
                            <td>{{ $account->balance }}</td>
                            <td>{{ $account->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>Date Of Birth</th>
                        <th>Balance</th>
                        <th>Created</th>
                    </tr>
                    </tfoot>
                </table>
                {{ $accounts->links() }}
            </div>
        </div>
    </section>

</x-app-layout>

<script>
    document.addEventListener('livewire:load', function () {
        $('#accounts-list').DataTable({
            paging: true,
            searching: true,
            info: true,
        });
        $('#accounts-list tfoot th').each(function (i) {
            var title = $('#accounts-list thead th')
                .eq($(this).index())
                .text();
            $(this).html(
                '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
            );
        });
        // Filter event handler
        $(table.table().container()).on('keyup', 'tfoot input', function () {
            table
                .column($(this).data('index'))
                .search(this.value)
                .draw();
        });
    });

    Livewire.hook('message.processed', (message, component) => {
        $('#accounts-list').DataTable().destroy();
        $('#accounts-list').DataTable({
            paging: true,
            searching: true,
            info: true
        });
    });
</script>
