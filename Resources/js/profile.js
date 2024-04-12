const fileInput = document.querySelector('#file-input-button');
const triggerButton = document.querySelector('#file-trigger-button');
const inputForm = document.querySelector('#picture-form');
const submitPic = document.querySelector('#submit-pic');

triggerButton.addEventListener('click', function(){
    fileInput.click();
});

inputForm.addEventListener('change', function(){
    if(fileInput.files.length > 0)
    {
        inputForm.submit();
    }
});

