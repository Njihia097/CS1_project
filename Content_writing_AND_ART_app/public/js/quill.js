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
    },
    placeholder: 'Start writing here...',
});

const uniqueID = chapterID ? `${contentID}-${chapterID}` : contentID;

const contentType = document.getElementById('content_type').value;
const chapterTitleContainer = document.getElementById('chapter-title-container');
const storyTitleContainer = document.getElementById('story-title-container');

// Show the correct title input based on content type
if (contentType === 'chapter') {
    storyTitleContainer.style.display = 'none';
} else {
    chapterTitleContainer.style.display = 'none';
}

const saveLoader = document.getElementById('save-loader');
const saveStatus = document.getElementById('save-status');

// Show loader
function showLoader() {
    saveLoader.classList.remove('hidden');
    saveStatus.innerHTML = `
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 text-gray-200 me-3 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
        </svg>
        Saving...
    `;
}

// Show saved status
function showSaved() {
    saveLoader.classList.add('hidden');
    saveStatus.textContent = 'Saved!';
    saveStatus.classList.remove('text-red-500');
    saveStatus.classList.add('text-green-500');
    isContentChanged = false;
}

// Load content from local storage if available
window.onload = function () {
    if (localStorage.getItem(`content_delta_${uniqueID}`)) {
        quill.setContents(JSON.parse(localStorage.getItem(`content_delta_${uniqueID}`)));
    }
    if (localStorage.getItem(`title_${uniqueID}`)) {
        document.getElementById('title').value = localStorage.getItem(`title_${uniqueID}`);
    }
    if (localStorage.getItem(`chapter_title_${uniqueID}`)) {
        document.getElementById('chapter_title').value = localStorage.getItem(`chapter_title_${uniqueID}`);
    }
    showSaved();
};

// Save content to local storage on change
quill.on('text-change', function() {
    if (quill.getText().trim() !== '') {
        localStorage.setItem(`content_delta_${uniqueID}`, JSON.stringify(quill.getContents()));
        debounceSave();
        isContentChanged = true;
    }
});

document.getElementById('title').addEventListener('input', function() {
    if (document.getElementById('title').value.trim() !== '') {
        localStorage.setItem(`title_${uniqueID}`, document.getElementById('title').value);
        debounceSave();
        isContentChanged = true;
    }
});

document.getElementById('chapter_title').addEventListener('input', function() {
    if (document.getElementById('chapter_title').value.trim() !== '') {
        localStorage.setItem(`chapter_title_${uniqueID}`, document.getElementById('chapter_title').value);
        debounceSave();
        isContentChanged = true;
    }
});

// Function to set the action and submit the form
function setAction(action) {
    document.getElementById('action').value = action;
    saveContent();
}

// Save the content to the hidden input before form submission
function saveContent() {
    const contentDelta = JSON.stringify(quill.getContents());
    document.getElementById('content-delta').value = contentDelta;
    showLoader();
    setTimeout(() => {
        showSaved();
        document.getElementById('content-form').submit();
    }, 1000); // Add delay for better UX
}

// Debounced save function to avoid frequent saves
function debounce(func, wait) {
    let timeout;
    return function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, arguments), wait);
    };
}


// Debounced save function
const debounceSave = debounce(() => {
    if (document.getElementById('title').value.trim() !== '' || quill.getText().trim() !== '') {
        showLoader();
        setTimeout(() => {
            showSaved();
        }, 1000); // Simulate save delay
    }
}, 1000);

setInterval(debounceSave, 30000); // Auto-save content every 30 seconds





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

// function setAction(action) {
//     document.getElementById('action').value = action;
//     saveContent();
// }

// function saveContent() {
//     const contentDelta =JSON.stringify(quill.getContents());
//     document.getElementById('content-delta').value = contentDelta;
//     document.getElementById('content-form').submit();
// }
