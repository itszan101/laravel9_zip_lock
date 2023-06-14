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
                    <h2 class="text-lg font-bold mb-4">File Upload</h2>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="file">Choose File:</label>
                            <input type="file" name="file" id="file">
                        </div>
                        <div>
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password">
                        </div>
                        <div>
                            <button type="submit">Upload</button>
                        </div>
                    </form>

                    <div class="file-list mt-4">
                        @foreach ($files as $file)
                            <div class="file-item">
                                <div class="file-name">{{ $file->name }}</div>
                                <form action="{{ route('files.download', $file->id) }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="password">Password:</label>
                                        <input type="password" name="password" id="password">
                                    </div>
                                    <div>
                                        <button type="submit">Download</button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
