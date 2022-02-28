if (document.getElementsByClassName('account-profile').length > 0) {
    let selects = document.getElementsByClassName('account-profile');
    for (let el of selects) {
        el.addEventListener('change', () => {setUserProfile(el)});
    }

    function setUserProfile(el) {
        pause.start();
        let url = router.generateUrl('setProfile', [], true);
        let data = {account: el.dataset.account_id, profile: el.value};
        console.log(data);
        api.post(url, data, (request) => {
            pause.stop();
        }, () => {
            pause.stop();
        });
    }
}
