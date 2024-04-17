function confirmDelete(entryID)
{
    const formID = '#entry-delete-' + entryID;
    const deleteForm = document.querySelector(formID);

    if(confirm('Are you sure you want to delete this entry?'))
    {
        deleteForm.submit();
    }
}