document.addEventListener('DOMContentLoaded', () => {
  const roleSelect = document.getElementById('roleSelect');
  const storeNameField = document.getElementById('storeNameField');

  if (roleSelect && storeNameField) {
    const toggleStoreField = () => {
      storeNameField.classList.toggle('hidden', roleSelect.value !== 'vendor');
    };

    roleSelect.addEventListener('change', toggleStoreField);
    toggleStoreField();
  }
});
