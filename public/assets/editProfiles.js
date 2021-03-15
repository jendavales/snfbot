if (document.getElementById('profilesModal') !== null) {
    const PROFILE_INPUTS_PREFIX = 'profile_';
    const PROFILE_OPTIONS_PREFIX = 'profileOption_';

    //Bind sections disabling to checkboxes
    let sections = [];
    ['adventures', 'items', 'quests'].forEach((type) => {
        let input = document.getElementById(PROFILE_INPUTS_PREFIX + type);
        let section = document.getElementById('profileSection_' + type);
        sections[type] = section;
        input.addEventListener('change', () => {
            section.classList.toggle('disabled')
        });
    });

    //Prepare variables
    let profileOptions = loadProfileOptions();
    let profileInputs = loadProfileInputs();
    let profileSelectOptions = document.getElementById('profileSelect_options');
    let profileSelect = document.getElementById('profileSelect');

    loadProfile(profileSelect.value);

    //Save button onclick - save
    document.getElementById('saveProfileButton').addEventListener('click', () => {
        saveProfile();
    })

    //Submit profile change with enter - save
    document.getElementById('profileEdit').addEventListener('submit', (e) => {
        e.preventDefault();
        saveProfile();
    });

    //Set profile on change
    profileSelect.addEventListener('change', function () {
        loadProfile(this.value);
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
            if (profileInputs[PROFILE_INPUTS_PREFIX + 'id'].value === 'undefined') {
                //create new options
                option = document.createElement('option');
                option.value = id;
                profileInputs[PROFILE_INPUTS_PREFIX + 'id'].value = id;
                console.log(profileInputs[PROFILE_INPUTS_PREFIX + 'id'].value);
                profileSelect.insertBefore(option, profileSelect.lastElementChild);
                profileSelect.value = id;
                profileOptions[PROFILE_OPTIONS_PREFIX + id] = option;
            } else {
                option = profileOptions[PROFILE_OPTIONS_PREFIX + id];
            }
            let settings = createCurrentInputSettings();
            option.innerHTML = profileInputs[PROFILE_INPUTS_PREFIX + 'name'].value;
            option.dataset.settings = JSON.stringify(settings);
            console.log(settings);
            pause.stop();
        }, () => {
            pause.stop();
        });
    }

    function loadProfile(optionId) {
        let settings = JSON.parse(profileOptions[PROFILE_OPTIONS_PREFIX + optionId].dataset.settings);

        //Set checkboxes
        ['items', 'quests', 'adventures', 'adventures_dinos'].forEach((type) => {
            profileInputs[PROFILE_INPUTS_PREFIX + type].checked = settings[type] === '1';

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
            profileInputs[PROFILE_INPUTS_PREFIX + type].value = settings[type];
        });
    }

    function loadProfileOptions() {
        let profileOptionsNoKeys = document.querySelectorAll('[id^="' + PROFILE_OPTIONS_PREFIX + '"]');
        let profileOptions = [];

        for (let i = 0; i < profileOptionsNoKeys.length; i++) {
            profileOptions[profileOptionsNoKeys[i].id] = profileOptionsNoKeys[i];
        }

        return profileOptions;
    }

    function loadProfileInputs() {
        let profileOptionsNoKeys = document.querySelectorAll('[id^="' + PROFILE_INPUTS_PREFIX + '"]');
        let profileOptions = [];

        for (let i = 0; i < profileOptionsNoKeys.length; i++) {
            profileOptions[profileOptionsNoKeys[i].id] = profileOptionsNoKeys[i];
        }

        return profileOptions;
    }

    function createCurrentInputSettings() {
        let settings = {};
        let prefixLength = PROFILE_INPUTS_PREFIX.length;

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
