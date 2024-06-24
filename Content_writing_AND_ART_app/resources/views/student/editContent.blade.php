<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
    #editor-container {
        height: 80vh;
        width: 100%;
    }

    .ql-container {
        border-color: white;
    }

    .ql-editor img {
        padding: 1.5rem;
        max-width: 150px;
        height: 450px;
        display: block;
        margin: 0 auto;
    }

    .image-loader {
        display: none;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
    }

    .image-loader.show {
        display: block;
    }

    .ql-editor .caption {
        display: block;
        text-align: center;
        font-style: italic;
        font-size: 0.9em;
        color: #555;
        -ms-flex-align: center;
        justify-content: center;
    }

    /* Sticky toolbar */
    .ql-toolbar.ql-snow {
    position: sticky;
    top: 0;
    z-index: 10;
    background: white;
    }

    </style>
</head>
<body>
    <x-app-layout>
        <form method="POST" action="#">
            @csrf
            @method('PUT')
            <div class="flex items-center justify-between px-4 mx-auto mt-4 border-b border-gray-100 max-w-7xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                     <img src="https://images6.fanpop.com/image/photos/39900000/Link-link-39963209-4058-3734.png" alt="Content's coverpage" class="object-contain w-20 h-20">
                    </div>
                    <h3 class="ml-4 text-xl font-semibold">Title</h3>
                </div>

                <div class="flex justify-end">
                <x-button type="submit">
                    {{ __('Save Content') }}
                </x-button>
                </div>
            </div>
            <div class="flex flex-col items-center px-6 mt-6 mb-6">
                <input type="hidden" name="content_delta" id="content-delta">
                <div id="editor-container" class="mb-6"></div>
            </div>
        </form>
    </x-app-layout>

    <div class="image-loader" id="image-loader">
        <img src="/path/to/loader.gif" alt="Loading...">
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script src="{{ asset('js/quill.js') }}"></script>
</head>
<body>

    <!-- <script>
        // Initialize Quill editor
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image', 'video'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['clean']
                ],
                imageResize: {
                    displaySize: true
                }
            }
        });

        // Custom image handler
        function selectLocalImage() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = () => {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imageURL = e.target.result;
                        insertToEditor(imageURL);
                    };
                    reader.readAsDataURL(file);
                }
            };
        }

        function insertToEditor(url) {
            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', url);

            // Prompt for caption
            const caption = prompt('Enter image caption (optional):', '');
            if (caption) {
                quill.insertText(range.index + 1, `\n${caption}`, { 'class': 'caption' });
            }
        }

        // Add image handler to the toolbar
        quill.getModule('toolbar').addHandler('image', selectLocalImage);

        // Save the content to the hidden input before form submission
        const form = document.querySelector('form');
        form.onsubmit = () => {
            const contentDelta = quill.root.innerHTML;
            document.getElementById('content-delta').value = contentDelta;
        };
    </script> -->
</body>
</html>
