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

            // Show the loader
            const loader = document.getElementById('image-loader');
            loader.classList.add('show');
        }
    };
}

function insertToEditor(url) {
    const range = quill.getSelection();
    quill.insertEmbed(range.index, 'image', url);

    // Hide the loader
    const loader = document.getElementById('image-loader');
    loader.classList.remove('show');

// Prompt for caption
const caption = prompt('Enter image caption (optional):', '');
if (caption) {
    quill.insertText(range.index + 1, `\n${caption}\n`, {
        'align': 'center',
        'italic': true,
        'size': '1.5em',
        'color': '#555',
        'margin-top': '-2rem',
    });
}
}

// Add image handler to the toolbar
quill.getModule('toolbar').addHandler('image', selectLocalImage);

// MutationObserver for handling image insertions
const editor = document.querySelector('.ql-editor');
const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
        if (mutation.addedNodes.length) {
            mutation.addedNodes.forEach(node => {
                if (node.tagName === 'IMG') {
                    // Handle image insertion logic if needed
                }
                if (node.tagName === 'IFRAME' && node.classList.contains('ql-video')) {
                    // Set the standard size for videos
                    node.style.width = '560px';
                    node.style.height = '315px';
                    node.style.display = 'block';
                    node.style.margin = '0 auto';
                }
            });
        }
    });
});

observer.observe(editor, { childList: true, subtree: true });

// Save the content to the hidden input before form submission
const form = document.querySelector('form');
form.onsubmit = () => {
    const contentDelta = quill.root.innerHTML;
    document.getElementById('content-delta').value = contentDelta;
};
