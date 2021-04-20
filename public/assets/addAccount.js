if (document.getElementById('addAccountModal') !== null) {
    let addAccountOpened = true; // false when registration is added and selected
    let addButton = document.getElementById('addAccountSubmit');
    let addAccountForm = document.getElementById('addAccountForm');

    addButton.addEventListener('click', () => {
        if (addAccountOpened) {
            pause.start();
            addAccountForm.submit();
        } else {
            //Submit registration form
        }
    });
}
