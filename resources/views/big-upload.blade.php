<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @csrf
    <input type="file" id="up">Chose</input>
    <button id="upp">Upload</button>
    <script src="/js/resumable.js"></script>
    <script>
        var resumable = new Resumable({
            // Use chunk size that is smaller than your maximum limit due a resumable issue
            // https://github.com/23/resumable.js/issues/51
            chunkSize: 99 * 1024 * 1024, // 99MB
            simultaneousUploads: 3,
            testChunks: false,
            throttleProgressCallbacks: 1,
            // Get the url from data-url tag
            target: "/large-upload",
            // Append token to the request - required for web routes
            query: {
                _token: document.querySelector("input[name=_token]").value,
            }
        });
        resumable.assignBrowse(document.getElementById("up"))
        document.getElementById("upp").onclick = (e) => resumable.upload();
    </script>
</body>

</html>