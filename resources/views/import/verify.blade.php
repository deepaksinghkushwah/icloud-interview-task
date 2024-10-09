<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Result Verify') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          Total Records: {{$totalRecords}}<br>
          due_amount: {{$due_amount}}<br>
          paid_amount Total: {{$paid_amount}}<br>
          concession_amount Total: {{$concession_amount}}<br>
          scholarship_amount Total: {{$scholarship_amount}}<br>
          reverse_concession_amount Total: {{$reverse_concession_amount}}<br>
          write_off_amount Total: {{$write_off_amount}}<br>
          adjusted_amount Total: {{$adjusted_amount}}<br>
          refund_amount Total: {{$refund_amount}}<br>
          fund_trancfer_amount Total: {{$fund_trancfer_amount}}<br>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
