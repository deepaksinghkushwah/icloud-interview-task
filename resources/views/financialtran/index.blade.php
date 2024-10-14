<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Financial Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-4">
                        <form action="" method="GET" class="flex items-center gap-2 justify-end">
                            <input type="text" name="voucher_no" class="px-4 py-2"
                                placeholder="Search by voucher no" />
                            <button class="bg-blue-700 text-white px-4 py-2">Search</button>
                            <a href="{{route('financialtran.index')}}" class="bg-red-700 text-white px-4 py-2">Reset</a>
                        </form>
                    </div>
                    <table class="w-full border-separate">
                        <thead>
                            <tr class="bg-orange-700 text-white">
                                <th class="px-3 py-1">Module</th>
                                <th class="px-3 py-1">Transaction ID</th>
                                <th class="px-3 py-1">Admin No</th>
                                <th class="px-3 py-1">Amount</th>
                                <th class="px-3 py-1">CRDR</th>
                                <th class="px-3 py-1">Transaction Date</th>
                                <th class="px-3 py-1">Academic Year</th>
                                <th class="px-3 py-1">Entry Mode No</th>
                                <th class="px-3 py-1">Voucher No</th>
                                <th class="px-3 py-1">Branch</th>
                                <th class="px-3 py-1">Type Of Concession</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="border px-3 py-1">{{ $item->module->module_name }}</td>
                                    <td class="border px-3 py-1">{{ $item->transid }}</td>
                                    <td class="border px-3 py-1">{{ $item->admno }}</td>
                                    <td class="border px-3 py-1">{{ $item->amount }}</td>
                                    <td class="border px-3 py-1">{{ $item->crdr }}</td>
                                    <td class="border px-3 py-1">{{ $item->trandate }}</td>
                                    <td class="border px-3 py-1">{{ $item->acadyear }}</td>
                                    <td class="border px-3 py-1">{{ $item->entrymodeno }}</td>
                                    <td class="border px-3 py-1 required:">
                                      <a href="javascipt:void(0);" class="group">
                                      {{ $item->voucherno }}
                                      </a>
                                      <div class="absolute hidden group-hover:block group-hover:bg-red-800">
                                        Hello
                                      </div>
                                    </td>
                                    <td class="border px-3 py-1">{{ $item->branch->branch_name }}</td>
                                    <td class="border px-3 py-1">
                                        {{ $item->type_of_concession == 1 ? 'Concession' : 'Scholarship' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="py-3" colspan="12">{{ $items->withQueryString()->links() }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
