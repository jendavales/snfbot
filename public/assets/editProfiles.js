if (document.getElementById('profilesModal') !== null) {
    //Bind sections disabling to checkboxes
    let sections = [];
    ['adventures', 'items', 'quests'].forEach((type) => {
        let input = document.getElementById('profile_' + type);
        let section = document.getElementById('profileSection_' + type);
        sections[type] = section;
        input.addEventListener('change', () => {
            section.classList.toggle('disabled')
        });
    });

    let profileOptions = loadProfileOptions();
    let profileInputs = loadProfileInputs();
    let profileSelectOptions = document.getElementById('profileSelect_options');

    //Set profile on change
    let profileSelect = document.getElementById('profileSelect');
    profileSelect.addEventListener('change', function () {
        loadProfile(this.value);
    });
    loadProfile(profileSelect.value);

    //Save button onclick - save
    document.getElementById('saveProfileButton').addEventListener('click', () => {
        saveProfile();
    })

    document.getElementById('profileEdit').addEventListener('submit', (e) => {
       console.log('submit');
       e.preventDefault();
       saveProfile();
    });

    function saveProfile() {
        pause.start();
        let url = router.generateUrl('saveProfile', [], true);

        data = {};
        for ([key, element] of Object.entries(profileInputs)) {
            //this is how checkboxes behave (when not checked, no data omitted)
            if (element.type === 'checkbox') {
                if (element.checked) {
                    data[key] = 'on';
                }
                continue;
            }

            data[key] = element.value;
        }

        api.post(url, data, (request) => {
            //success, update preloaded settings and options
            let id = JSON.parse(request.responseText).id;
            let option;
            if (profileInputs['profile_id'].value === 'undefined') {
                //create new options
                option = document.createElement('option');
                option.value = id;
                profileInputs['profile_id'].value = id;
                console.log(profileInputs['profile_id'].value);
                profileSelect.insertBefore(option, profileSelect.lastElementChild);
                profileSelect.value = id;
                profileOptions['profileOption_' + id] = option;
            } else {
                //todo: add constant
                option = profileOptions['profileOption_' + id];
            }
            let settings = createCurrentInputSettings();
            option.innerHTML = profileInputs['profile_name'].value;
            option.dataset.settings = JSON.stringify(settings);
            console.log(settings);
            pause.stop();
        }, () => {
            pause.stop();
        });
    }

    function loadProfile(optionId) {
        let settings = JSON.parse(profileOptions['profileOption_' + optionId].dataset.settings);

        //Set checkboxes
        ['items', 'quests', 'adventures', 'adventures_dinos'].forEach((type) => {
            profileInputs['profile_' + type].checked = settings[type] === '1';

            if (type !== 'adventures_dinos') {
                if (settings[type] === '1') {
                    sections[type].classList.remove('disabled');
                } else {
                    sections[type].classList.add('disabled');
                }
            }
        });

        //Set other inputs
        ['name', 'items_greed', 'items_speed', 'items_sunProtection', 'quests_xp', 'quests_gold', 'items_action', 'id'].forEach((type) => {
            profileInputs['profile_' + type].value = settings[type];
        });
    }

    function loadProfileOptions() {
        let profileSelect = document.querySelectorAll('[id^="profileOption_"]');
        let profileOptions = [];

        for (let i = 0; i < profileSelect.length; i++) {
            profileOptions[profileSelect[i].id] = profileSelect[i];
        }

        return profileOptions;
    }

    function loadProfileInputs() {
        let profileSelect = document.querySelectorAll('[id^="profile_"]');
        let profileOptions = [];

        for (let i = 0; i < profileSelect.length; i++) {
            profileOptions[profileSelect[i].id] = profileSelect[i];
        }

        return profileOptions;
    }

    function createCurrentInputSettings() {
        let settings = {};
        //todo: constant
        let prefixLength = "profile_".length;

        for ([key, element] of Object.entries(profileInputs)) {
            if (element.type === 'checkbox') {
                settings[key.substr(prefixLength)] = element.checked ? '1' : '0';
                continue;
            }

            settings[key.substr(prefixLength)] = element.value;
        }

        return settings;
    }
}
