<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Import CSV') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @include('components.form-error')
          <form action="{{ route('import.processCsvImport') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex">
              <input type="file" class="" name="csv" id="">
              <button type="submit" class="bg-blue-800 text-white  px-4 py-2 rounded-lg shadow-lg">Upload</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
