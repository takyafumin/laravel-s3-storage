@php
    use Illuminate\Support\Str;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>

    <!-- アップロード機能 -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('s3.upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="file">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-400 text-white rounded px-4 py-2"">アップロード</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ファイル一覧 -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="overflow-x-auto relative">
                <table class="w-full text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <td>No</td>
                            <td>ファイル</td>
                            <td>リンク</td>
                            <td>リンク(署名付き)</td>
                            <td>ダウンロード</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($file_list as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item['filePath'] }}</td>
                                <td>
                                    <a target="_blank" href="{{ $item['url'] }}"><span
                                            class="text-blue-500">リンク</span></a>
                                </td>
                                <td>
                                    <a target="_blank" href="{{ $item['fileUrl'] }}"><span
                                            class="text-blue-500">リンク</span></a>
                                </td>
                                <td>
                                    <a
                                        href="{{ route('s3.download', ['name' => Str::padLeft($loop->index + 1, 8, '0') . '.' . $item['fileExtention'], 'origin_name' => $item['filePath']]) }}">
                                        <button
                                            class="bg-green-500 hover:bg-green-400 text-white rounded px-4 py-2"">ダウンロード</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
