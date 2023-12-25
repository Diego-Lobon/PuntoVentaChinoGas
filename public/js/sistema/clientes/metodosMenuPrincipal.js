const btnDelete = document.querySelector('.btn-delete');

btnDelete.addEventListener('click', (event) => {
    event.preventDefault();
    const form = event.target.closest('form');
    const csrfToken = event.target.dataset.csrf;
    const method = event.target.dataset.method;
    form.setAttribute('method', method);
    const csrfField = document.createElement('input');
    csrfField.setAttribute('type', 'hidden');
    csrfField.setAttribute('name', '_token');
    csrfField.setAttribute('value', csrfToken);
    form.appendChild(csrfField);
    form.submit();
});