<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
    <style>
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        .file-list {
            margin-top: 20px;
        }
        .file-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .file-item .file-name {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="container">
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

        <h2>File Upload</h2>

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

        <div class="file-list">
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
</body>
</html>
